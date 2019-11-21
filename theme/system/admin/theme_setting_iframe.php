<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <style>
        html {
            font-size: 12px;
        }
    </style>
    
<script src="/static/js/jquery-3.3.1.min.js"></script>

<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'>
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css'>
<script src="https://cdn.jsdelivr.net/npm/@json-editor/json-editor@latest/dist/jsoneditor.min.js"></script>

    <div id="editor_holder"></div>
    <button type="button" class="btn_save btn btn-primary btn-lg btn-block">保存</button>
<script>
    let schema = {
        "title": "主题配置",
        "type": "object",
        "$ref": "/admin/theme/getSchema"
    }
    let element = window.document.getElementById('editor_holder')
    let config = {
        schema: {},
        object_layout: "grid",
        ajax: true
    }
    config['schema'] = schema;
    JSONEditor.defaults.theme = 'bootstrap4';
    JSONEditor.defaults.iconlib = 'fontawesome4';
    var editor = new window.JSONEditor(element, config);
    editor.on('ready',function() {
        // Now the api methods will be available
        editor.validate();
        $.get('/admin/theme/getSetting').then(function(data) {
            editor.setValue(data);
        });
    });
    $('.btn_save').click(function() {
        $.post('/admin/theme/saveSetting', {
            setting: JSON.stringify(editor.getValue())
        }).then(function(data) {

        });
        console.log(editor.getValue());
    });
    // this.editor.setValue({
    //         "name": "Jeremy Dossssrn",
    //         "age": 25,
    //         "favorite_color": "#ffa500",
    //         "gender": "male",
    //         "date": "",
    //         "location": {},
    //         "pets": [
    //             {
    //             "type": "dog",
    //             "name": "Walter"
    //             },
    //             {
    //             "type": "dog",
    //             "name": ""
    //             }
    //         ]
    //         });
    // console.log(this.editor)
</script>
</body>
</html>