
const { src, dest, parallel } = require('gulp');
const gulp       = require('gulp');
const sass       = require('gulp-sass');
const minifyCSS  = require('gulp-csso');
const concat     = require('gulp-concat');
const watch      = require('gulp-watch');
const sourcemaps = require('gulp-sourcemaps');
const connect    = require('gulp-connect');
const util       = require('util');
const exec       = util.promisify(require('child_process').exec);
const rimraf     = require("rimraf");
const fs         = require("fs");
const open       = require("gulp-open");
const ftpClient  = require('ftp');
const mkdir      = util.promisify(fs.mkdir);
const request    = require('request');
const readline   = require('readline');

const inSCSS = 'static/scss/*.scss';
const inHTML = 'static/*.html';

const shell = {
    ask : async function(question)
    {
        return new Promise(r=>{
            const rl = readline.createInterface({
              input: process.stdin,
              output: process.stdout
            });

            rl.question(question, (answer) => {
                rl.close();
                r(answer);
            });
        })
    },

    exec : async function(cmds)
    {
        if(!Array.isArray(cmds)) return shell.exec([cmds]);
        for(i in cmds)
        {
            await exec(cmds[i]);
        }
    }
}

const config = {
    init : async function() {
        if(!this._init) {
            try {
                this._config = require('./gulpfile.settings.json');
                this._init = true;
            }
            catch (e) {
                await this.install();
            }
        }
    },

    get : async function() {
        await this.init();
        return this._config;
    },

    install : async function() {
        console.log("Initialize project");
        return new Promise(async r=>{
            let url = await shell.ask("FTP url :");
            let user = await shell.ask("FTP user :");
            let password = await shell.ask("FTP password :");

            this._config = {
                ftp : {url,user,password}
            };
            fs.writeFileSync('gulpfile.settings.json', JSON.stringify(this._config, null, 2), 'utf8', _=>r());
        })
    }
}

const folder = {
    create : async function (paths) {
        if(!Array.isArray(paths)) return folder.create([paths]);
        for(path of paths) {
            let exist = await folder.exist(path)
            if(!exist) {
                await mkdir(path)
            }
        }
    },

    exist : async function (paths) {
        if(!Array.isArray(paths)) return folder.exist([paths]);

        let result = true;
        for(path of paths) {
            result &= fs.existsSync(path);
        }
        return result;
    },

    remove : async function (paths) {
        if(!Array.isArray(paths)) return folder.remove([paths]);
        for(path of paths) {
            let exist = await folder.exist(path)
            if(exist) {
                rimraf.sync(path);
            }
        }
    }
}


const docker = {
    install : async function() {
        // Is already installed? Does data/db exist?
        const installed = await folder.exist(["data", "data/db"]);
        if(!installed) {
            console.log('Initialiaze Docker env...')
            // Create folders
            await folder.create(["data", "data/db"])

            // Build & start
            console.log('Starting containers');
            await shell.exec([
                "docker-compose build --no-cache",
                "docker-compose up -d"
            ])

            // Wait mysql
            console.log('Waiting mysql');
            let loop = true;
            while(loop) {
                try
                {
                    process.stdout.write(".");
                    await shell.exec(["docker-compose exec -T mysql mysql -u root -proot -D information_schema -e ';'"]);
                    loop = false;
                }
                catch(e) { }
            }
            process.stdout.write("\n");

            // Install octobercms
            console.log('Install october');
            await shell.exec([
                "docker-compose exec -T web php artisan october:up",
                "docker-compose exec -T mysql mysql -u root -proot -D octobercms -e 'INSERT INTO system_parameters(`namespace`, `group`, `item`, `value`) VALUES (\"cms\", \"theme\", \"active\", \"\\\"without-origins\\\"\");'"
            ])

            // Stop
            console.log('Stopping containers');
            await this.stop();
        }
    },

    clean : async function() {
        console.log('Cleaning logs');
        await folder.remove("data/logs")
        await folder.create(["data", "data/logs", "data/logs/apache2", "data/logs/octobercms"])
    },

    start : async function() {
        await this.install();
        await this.clean();
        console.log('Starting containers');
        await shell.exec("docker-compose up -d");
    },

    stop : async function() {
        console.log('Stopping containers');
        await shell.exec("docker-compose down");
    },

    uninstall : async function() {
        await this.stop();
        console.log('Clear local data');
        await folder.remove("data");
        await this.install();
    },

    export : async function() {
        await this.stop();
        await this.start();
        await folder.remove('tmp');
        await shell.exec("docker cp wo-web:/var/www/html tmp");
    }
}

const ftp = {
    _client : null,

    connect : async function() {
        if(!this._client)
        {
            return new Promise(async r=>{
                let conf = await config.get();
                this._client = new ftpClient();
                this._client.on('ready', ()=>r());
                this._client.connect({
                    host : conf.ftp.url,
                    user : conf.ftp.user,
                    password :conf.ftp.password
                });
            })
        }
    },

    get : async function(from, to) {
        if(this._client)
        {
            return new Promise(r=>{
                this._client.get(from, function(err, stream) {
                    if (err) throw err;
                    stream.once('close', function() { r(); });
                    stream.pipe(fs.createWriteStream(to));
                });
            })
        }
    },

    removeDir : async function(path) {
        if(this._client)
        {
            return new Promise(r=>{
                r();
                try {
                    this._client.rmdir(path, true, ()=>r());
                }
                catch(e)
                {
                    r()
                }
            })
        }
    },

    removeFile : async function(path) {

        if(this._client)
        {
            return new Promise(r=>{
                try {
                    this._client.delete(path, ()=>r());
                }
                catch(e)
                {
                    r();
                }
            })
        }
    },

    copy : async function(from, to, count, copied) {
        if(!count)
        {
            count = this.count(from);
            copied = 0;
        }
        if(this._client)
        {
            if(fs.lstatSync(from).isDirectory())
            {
                copied =await this.copyDir(from, to, count, copied);
            }
            else
            {
               copied =await this.copyFile(from, to, count, copied);
            }
        }
        return copied;
    },

    copyDir : async function(from, to, count, copied) {
        if(this._client)
        {
            return new Promise(r=>{
                this._client.mkdir(to, async ()=>{
                    let content =  fs.readdirSync(from)
                    for(path of content)
                    {
                        copied = await this.copy(from + '/' + path, to + '/' + path, count, copied);
                    }
                    r(copied);
                });
            })
        }
    },

    copyFile : async function(from, to, count, copied)
    {
        if(this._client)
        {
            return new Promise(r=>{
                copied++;
                console.log(copied + "/" + count + ' : ' + from );
                this._client.put(from, to, ()=>r(copied));
            })
        }
    },

    count : function(path)
    {
        let count = 0;
        if(fs.lstatSync(path).isDirectory())
        {
            let content =  fs.readdirSync(path)
            for(p of content)
            {
                count += this.count(path + '/' + p);
            }
        }
        else
        {
            return 1;
        }
        return count;
    }
}

const tasks = {
    'build' : function() {
        this['build-css']();
        this['build-html']();
    },

    'build-css' : function() {
        return src(inSCSS)
            .pipe(sourcemaps.init())
            .pipe(sass())
            .pipe(concat('style.css'))
            .pipe(minifyCSS())
            .pipe(sourcemaps.write('.'))
            .pipe(dest('static/css'))
            .pipe(connect.reload());
    },

    'build-html': function() {
        return src(inHTML)
            .pipe(sourcemaps.init())
            .pipe(connect.reload());
    },

    'docker-start' : function() { docker.start(); },
    'docker-stop' : function() { docker.stop(); },
    'docker-reset' : function() { docker.uninstall(); },

    'push-static' : function() {
        ftp.connect().then(async ()=>{
            // Remove previous folder
            await ftp.removeDir("static.withoutorigins.fr")

            // Copy static folder
            await ftp.copy("static", "static.withoutorigins.fr")
        });
    },

    'push-staging' : function() {
        ftp.connect().then(async ()=>{
            console.log("Cleaning themes and plugins");
            await ftp.removeDir("staging.withoutorigins.fr/themes");
            await ftp.removeDir("staging.withoutorigins.fr/plugins");

            console.log("Uploading themes and plugins");
            await ftp.copy("octobercms/themes", "staging.withoutorigins.fr/themes");
            await ftp.copy("octobercms/plugins", "staging.withoutorigins.fr/plugins");

            console.log("Migrating db");
            request('http://devops.withoutorigins.fr/artisan.php?command=1&env=0', { }, (err, res, body) => {
                if (err) { return console.log(err); }
                console.log(body.replace(/\<span style="width:10px;display:inline-block;"\>\<\/span\>/g, '  ').replace(/\<br\>/g, '\n'));
                console.log("Done!")
            })
        });
    },

    'default' : function() {
        docker.start().then(function(){
            connect.server({livereload: true});
            gulp.src(__filename)
                .pipe(open({uri: "http://localhost:8081"}))
                .pipe(open({uri: "http://localhost:8081/backend"}));
            watch(inSCSS, tasks['build-css']);
            watch(inHTML, tasks['build-html']);
        })
    }
}

for( let i in tasks) gulp.task(i, tasks[i]);
