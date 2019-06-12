Number.prototype.format = function(n, x) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
    return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
};

// numero.formatMoney('2', ',', '.')
Number.prototype.formatMoney = function(c, d, t){
var n = this, 
    c = isNaN(c = Math.abs(c)) ? 2 : c, 
    d = d == undefined ? "." : d, 
    t = t == undefined ? "," : t, 
    s = n < 0 ? "-" : "", 
    i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", 
    j = (j = i.length) > 3 ? j % 3 : 0;
   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
 };


     //Retorna o index de um array baseado em um identificador (ex. 1 *id) e uma ancora (ex. ID)
    Array.prototype.indexFromAttr = function arrayObjectIndexOf(anchor, identifier) {
        for (var i = 0, len = this.length; i < len; i++) {
            if (this[i][anchor] === identifier) {
                return i
            }
        }
        return -1;
    }

    //Retorna o objeto de um array baseado em um identificador (ex. 1 *id) e uma ancora (ex. ID)
    Array.prototype.findFromAttr = function arrayObjectIndexOf(anchor, identifier) {
        for (var i = 0, len = this.length; i < len; i++) {
            if (this[i][anchor] === identifier) {
                return this[i];
            }
        }
        return false;
    }

    //Retorna um boolean de um array baseado em um identificador (ex. 1 *id) e uma ancora (ex. ID)
    Array.prototype.checkFromAttr = function arrayObjectIndexOf(anchor, identifier) {
        for (var i = 0, len = this.length; i < len; i++) {
            if (this[i][anchor] === identifier) {
                return true;
            }
        }
        return false;
    }

    //Retorna um boolean de um array baseado em um identificador (ex. 1 *id) e uma ancora (ex. ID)
    Array.prototype.checkIfContains = function arrayObjectIndexOf(obj) {
        for (var i = 0, len = this.length; i < len; i++) {
            if (this[i] === obj) {
                return true;
            }
        }
        return false;
    }

    //Remove um objeto de um array localizado por um identificador passado
    Array.prototype.removeFromAttr = function arrayObjectIndexOf(anchor, identifier) {
        for (var i = 0, len = this.length; i < len; i++) {
            if (this[i][anchor] === identifier) {
                this.splice(i, 1);
                return true
            }
        }
        return false;
    }

    //Remove um objeto de um array localizado por um identificador passado
    Array.prototype.removeFromObj = function arrayObjectIndexOf(object) {
        for (var i = 0, len = this.length; i < len; i++) {
            if (this[i] === object) {
                this.splice(i, 1);
                return true
            }
        }
        return false;
    }

    //Remove um objeto de um array localizado por dois identificadores e duas ancoras.
    Array.prototype.removeFromTwoAttr = function arrayObjectIndexOf(anchor, identifier, anchor2, identifier2) {
        for (var i = 0, len = this.length; i < len; i++) {
            if (this[i][anchor] === identifier && this[i][anchor2] === identifier2) {
                this.splice(i, 1);
                return true
            }
        }
        return false;
    }

    //Retorna o objeto de um array baseado em DOIS identificador (ex. 1 *id) e uma ancora (ex. ID)
    Array.prototype.findFromTwoAttr = function arrayObjectIndexOf(anchor, identifier, anchor2, identifier2) {
        for (var i = 0, len = this.length; i < len; i++) {
            if (this[i][anchor] === identifier && this[i][anchor2] === identifier2) {
                return this[i];
            }
        }
        return false;
    }