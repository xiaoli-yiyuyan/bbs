var uglify = require("uglify-js");
var babel = require('babel-core');
var fs = require('fs');
// 文件转码（异步）
babel.transformFile('dev/index.js', {}, function (err, result) {
    
    var result2 = uglify.minify(result.code, {
    });
    fs.writeFileSync("./test/iamEditor.min.js",result2.code);
});