class IamEditor {
    constructor() {
        this.selection = window.getSelection();
    }

    init() {
        this.dom.setAttribute('contenteditable', true);
        this.dom.addEventListener('keydown', (event) => {
            console.log(event);
            var range = this.getRange();
            if (range.commonAncestorContainer.parentNode.getAttribute('unit')) {
                var textEle  =  range.commonAncestorContainer;
                range.setStart(range.startContainer,  0);
                range.setEnd(range.endContainer,  textEle.length);

                if ([37, 38, 39, 40].indexOf(event.keyCode) == -1) {
                    range.commonAncestorContainer.parentNode.parentNode.removeChild(range.commonAncestorContainer.parentNode);
                }
                    
                if (event.keyCode === 8) {
                    return false;
                }
            }
        });
        
        this.dom.addEventListener('paste', function(event){
            let plainText  =  event.clipboardData.getData('text/plain');  // 无格式文本
            document.execCommand('insertText', false, plainText);
            event.preventDefault();
        });
        document.addEventListener('click', (event) => {
            if (this.dom.contains(event.target) && event.target.getAttribute('unit')) {
                var range = this.getRange();
                var textEle  =  range.commonAncestorContainer;
                range.setStart(range.startContainer,  0);
                range.setEnd(range.endContainer,  textEle.length);
            }
        });
    }

    getRange() {
        return this.selection.getRangeAt(0);
    }

    getBox(dom) {
        this.dom = dom;
        this.init();
    }
    
    focus() {
        this.dom.focus();
    }

    insertHTML(html) {
        this.focus();
        document.execCommand('insertHTML', false, html + '&#8203;');
        var range = this.getRange();
        range.setStart(range.endContainer,  0);
        range.setEnd(range.endContainer,  0);
    }

    toUbb() {
        
        let dom = this.dom.cloneNode(true);
        let code_dom = dom.querySelectorAll('[data-code]');
        for (let value of code_dom) {
            var code = value.dataset.code;
            value.parentNode.replaceChild(document.createTextNode(code), value);
        }
        return dom.innerText;
    }
}