'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var IamEditor = function () {
    function IamEditor() {
        _classCallCheck(this, IamEditor);

        this.selection = window.getSelection();
    }

    _createClass(IamEditor, [{
        key: 'init',
        value: function init() {
            var _this = this;

            this.dom.setAttribute('contenteditable', true);
            this.dom.addEventListener('keydown', function (event) {
                console.log(event);
                var range = _this.getRange();
                if (range.commonAncestorContainer.parentNode.getAttribute('class') == 'alt_user') {
                    if ([37, 38, 39, 40].indexOf(event.keyCode) == -1) {
                        $(range.commonAncestorContainer.parentNode).remove();
                    }

                    if (event.keyCode === 8) {
                        return false;
                    }
                }
            });
        }
    }, {
        key: 'getRange',
        value: function getRange() {
            return this.selection.getRangeAt(0);
        }
    }, {
        key: 'getBox',
        value: function getBox(dom) {
            this.dom = dom;
            this.init();
        }
    }, {
        key: 'focus',
        value: function focus() {
            this.dom.focus();
        }
    }, {
        key: 'insertHTML',
        value: function insertHTML(html) {
            document.execCommand('insertHTML', false, html + '&#8203;');
        }
    }]);

    return IamEditor;
}();
