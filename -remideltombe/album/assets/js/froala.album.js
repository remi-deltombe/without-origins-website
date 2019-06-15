(function($) {

    const commandName = 'album';
    const iconName = commandName + 'Icon';
    let albums = {};

    $.ajax('/backend/remideltombe/album/albums/list').then((results)=>{
        albums = {};
        for(album of results)
        {
            albums[album.id] = album;
        }
    });

    const buildListItem = (name, value) => {
        return '<li><a class="fr-command" data-cmd="' + commandName +
          '" data-param1="' + value + '" title="' + name + '">' +
          name + '</a></li>';
    };

    const buildInsert = (i) => {
        const album = albums[i];
        let html = `<p class="album"><!-- [[ALBUM:START]] --><!-- [[ID:${i}]] -->Album : <b>${album.name}</b><!-- [[ALBUM:END]] --></p>`;
        return html;
    };

    $.oc.richEditorButtons.splice($.oc.richEditorButtons.length - 1, 0, 'album');

    $.FroalaEditor.RegisterCommand(commandName, {
        title: 'Albums',
        type: 'dropdown',
        icon: '<i class="icon-camera-retro"></i>',
        undo: true,
        focus: true,
        refreshAfterCallback: true,

        callback: function (cmd, val, params) {
            this.html.insert(buildInsert(val));
        },

        refreshOnShow: ($btn, $dropdown) => {
            const editorInstance = this;
            const list = $dropdown.find('ul.fr-dropdown-list');

            let listItems = '';
            for(let k in albums)
            {
                listItems += buildListItem(albums[k].name, k+'');
            }
            list.empty().append(listItems);
        }
    });
})(jQuery);