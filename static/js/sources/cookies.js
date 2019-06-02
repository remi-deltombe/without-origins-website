
class Cookies
{
    static get(name, _default = undefined)
    {
        let cookies = Cookies.retrieve();
        return cookies[name]  ? cookies[name].value : _default;
    }

    static set(name, value, expiration=1)
    {
        let cookies = {};
        cookies[name] = cookies[name]  ? cookies[name] : { name };
        cookies[name].value = value;
        cookies[name].expiration = expiration;
        Cookies.store(cookies);

    }

    static delete(name)
    {
        let cookies = Cookies.retrieve();
        cookies[name] = cookies[name]  ? cookies[name] : { name };
        cookies[name].value = '';
        Cookies.store(cookies);
    }

    static exist(name)
    {
        let cookies = Cookies.retrieve();
        return cookies[name]  ? true : false;
    }

    static retrieve()
    {
        let cookies = {};
        let contents = document.cookie.split(';');
        for(let content of contents)
        {
            let [name, value] = content.split('=').map(v=>v.trim())
            cookies[name] = { name, value, expiration:1 }
        }

        return cookies;
    }

    static store(cookies)
    {
        console.log(cookies);
        for(let i in cookies)
        {
            let cookie = cookies[i];
            let name = cookie.name ? cookie.name : undefined;
            let value = cookie.value ? cookie.value : undefined;
            let expiration = cookie.expiration ? cookie.expiration : 1;

            if(name === undefined) return ;

            let date = new Date();
            date.setTime(date.getTime() + (expiration * 24 * 60 * 60 * 1000));
            
            document.cookie = name + "=" + value + ";expires=" + date.toUTCString() + ";path=/";
        }
    }
}

