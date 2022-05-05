/******************************************************
* Librairie minimaliste de gestion d'un formulaire Web
*
* Copyright 2019 Donatien Grolaux
*
* Permission is hereby granted, free of charge, to any person obtaining a copy of this software 
* and associated documentation files (the "Software"), to deal in the Software without restriction, 
* including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, 
* and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, 
* subject to the following conditions:
* 
* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, 
* INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
* IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, 
* WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE 
* OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

const lib = (function () {

    function serializeObject(form) {
        // cette fonction va parcourir tous les éléments du formulaire, et remplir un objet associatif
        let field, s = {};
        if (typeof form == 'object' && form.nodeName == "FORM") { // le paramètre est bien l'objet DOM d'un formulaire ?
            let len = form.elements.length; // longueur de tous les champs de ce formulaire
            for (i = 0; i < len; i++) { // parcours de ces champs
                field = form.elements[i];
                // le champ doit avoir un nom, être activé, et être d'un type qui a un sens pour ce serializeObject
                if (field.name && !field.disabled && field.type != 'file' && field.type != 'reset' && field.type != 'submit' && field.type != 'button') {
                    if (field.type == 'select-multiple') { // le select multiple est particulier car il faut un tableau pour retenir les différentes options sélectionnées
                        s[field.name] = [];
                        for (j = form.elements[i].options.length - 1; j >= 0; j--) {
                            if (field.options[j].selected)
                                s[field.name].push(field.options[j].value);
                        }
                    } else if (field.type == 'checkbox') { // le checkbox est particulier : value est toujours le même qu'il soit sélectionné ou pas. A la place, on prend .checked
                        s[field.name] = field.checked
                    } else if (field.type == 'radio')  { // le radio est particulier
                        if (field.checked) { // est-ce que l'élément est coché ?
                            s[field.name] = field.value;
                        } else if (s[field.name] === undefined) { // est-ce qu'il existe dans s ?
                            // ceci permet d'avoir null pour un groupe de radio si aucun champ n'est sélectionné
                            s[field.name] = null;
                        }
                    } else { // cas général : c'est value qui contient ce qu'a édité l'utilisateur
                        s[field.name] = field.value;
                    }
                }
            }
        }
        return s;
    }

    function deserializeObject(form, data) {
        // cette fonction va aussi parcourir le formulaire et non pas parcourir data
        if (typeof form == 'object' && form.nodeName == "FORM") {// le paramètre est bien l'objet DOM d'un formulaire ?
            let len = form.elements.length;
            for (i = 0; i < len; i++) {
                field = form.elements[i];
                // le champ doit avoir un nom, avoir une entrée dans data, être activé, et être d'un type qui a un sens pour ce serializeObject
                if (field.name && data[field.name] != undefined && !field.disabled && field.type != 'file' && field.type != 'reset' && field.type != 'submit' && field.type != 'button') {
                    if (field.type == 'select-multiple') { // le select multiple est particulier car il faut un tableau pour retenir les différentes options sélectionnées
                        for (j = form.elements[i].options.length - 1; j >= 0; j--) {
                            field.options[j].selected = (data[field.name].indexOf(field.options[j].value) != -1);
                        }
                    } else if (field.type == 'checkbox') { // le checkbox est particulier : value est toujours le même qu'il soit sélectionné ou pas. A la place, on prend .checked
                        field.checked = data[field.name];
                    } else if (field.type == 'radio') {
                        if (field.checked !== (data[field.name] === field.value)) {
                            field.checked = (data[field.name] === field.value) // coche le champ dont la valeur est la même que celle dans data
                        }
                    } else { // cas général : c'est value qui contient ce qui est visible à l'utilisateur
                        field.value = data[field.name]; 
                    }
                }
            }
        }
    }

    function serializeArray(form) {
        let field, s = [];
        if (typeof form == 'object' && form.nodeName == "FORM") {
            const len = form.elements.length;
            for (i = 0; i < len; i++) {
                field = form.elements[i];
                if (field.name && !field.disabled && field.type != 'file' && field.type != 'reset' && field.type != 'submit' && field.type != 'button') {
                    if (field.type == 'select-multiple') {
                        for (j = form.elements[i].options.length - 1; j >= 0; j--) {
                            if (field.options[j].selected)
                                s[s.length] = encodeURIComponent(field.name) + "=" + encodeURIComponent(field.options[j].value);
                        }
                    } else if ((field.type != 'checkbox' && field.type != 'radio') || field.checked) {
                        s[s.length] = encodeURIComponent(field.name) + "=" + encodeURIComponent(field.value);
                    }
                }
            }
        } else if (typeof form == 'object' && form.constructor=={}.constructor) {
            for(key in form) {
                const value=form[key];
                if (value instanceof Array) {
                    for(i=0; i<value.length; i++) {
                        s[s.length] = encodeURIComponent(key) + "=" + encodeURIComponent(value[i]);
                    }
                } else {
                    s[s.length]=encodeURIComponent(key)+"="+encodeURIComponent(value);
                }
            }
        }
        return s.join('&').replace(/%20/g, '+');
    }

    function isElement(element) {
        return element instanceof Element || element instanceof HTMLDocument;
    }

    function ajax({ url, type, data, success, error, mimeType }) {
        if (type === undefined) type = "GET";
        if (url === undefined) url = ".";
        const xmlhttp = new XMLHttpRequest();

        function getResponse() {
            if (xmlhttp.getResponseHeader('content-type')==="application/json") {
                try {
                    return JSON.parse(xmlhttp.responseText);
                } catch (e) {
                    if (error !== undefined) {
                        error(getResponse(), xmlhttp.status, xmlhttp);
                        success=undefined; error=undefined;
                    }
                    throw e;
                }
            } else {
                return xmlhttp.responseText;
            }
        }

        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == XMLHttpRequest.DONE) {   // XMLHttpRequest.DONE == 4
                if (xmlhttp.status == 200) {
                    if (success !== undefined) {                        
                        success(getResponse());
                        success=undefined; error=undefined;
                    }
                }
                else {
                    if (error !== undefined) {
                        error(getResponse(), xmlhttp.status, xmlhttp);
                        success=undefined; error=undefined;
                    }
                }
            }
        };
        xmlhttp.onabort = function () {
            if (error !== undefined) {
                error(null, "abort", xmlhttp);
                success=undefined; error=undefined;
            }
        }
        xmlhttp.onerror = function () {
            if (error !== undefined) {
                error(null, "error", xmlhttp);
                success=undefined; error=undefined;
            }
        }

        let toSend = undefined;
        xmlhttp.open(type, url, true);
        if (mimeType != undefined) {
            xmlhttp.setRequestHeader('Content-Type', mimeType);
        }
        if (data !== undefined) {
            if (typeof data === "string" || data instanceof String || typeof data === "number" || data instanceof Number) {
                if (mimeType===undefined) xmlhttp.setRequestHeader('Content-Type', 'text/plain');
                toSend = "" + data;
            } else if (isElement(data)) {
                if (data.nodeName == "FORM") {
                    if (mimeType===undefined) xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    toSend = serializeArray(data);
                } else throw "Cannot make ajax call with this data";
            } else if (data.constructor === {}.constructor || data.constructor===[].constructor) {
                if (mimeType==="application/json") {
                    toSend = JSON.stringify(data);
                } else {
                    if (mimeType===undefined) xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    toSend = serializeArray(data);    
                }
            } else throw "Cannot make ajax call with this data";
        }
        xmlhttp.send(toSend);
    }

    function validateNotEmpty(form,fields,msg) {
        const data=lib.serializeObject(form);
        let withError=false;
        for(let i=0; i<fields.length; i++) {
            const name=fields[i];
            if (data[name]!==undefined && data[name]==="") { // ce champ est vide
                setFieldError(form,name,msg);
                withError=true;
            } else {
                setFieldError(form,name,null);
            }
        }
        return withError;
    }

    function setFieldError(form,name,msg) {
            // cherche le message d'erreur qui suit le champ de ce nom
            let error=form.querySelector('[name="'+name+'"] + .error');
            if (msg!=null) {
                // est-il présent ?
                if (error===null) { // non : le créer
                    error=document.createElement("div"); // <div class="error">
                    error.setAttribute("class","error");
                    // trouver le dernier champ du formulaire possédant ce nom
                    const namefields=form.querySelectorAll('[name="'+name+'"]');
                    const namefield=namefields[namefields.length-1];
                    namefield.parentNode.insertBefore(error, namefield.nextSibling);
                } else { // oui : le vider
                    error.innerHTML="";
                }
                const text = document.createTextNode( msg );
                error.appendChild(text);
            } else if (error!==null) { // ce message d'erreur doit disparaître
                error.parentNode.removeChild(error);
            }
    }

    function ajaxError(error) {
        if (error===undefined) throw "Paramètre manquant";
        return function(response,status) {
            error.innerText=formatError(response,status);
        }
    }

    function formatError(response,status) {
        if ((typeof response=='string' || response instanceof "String") && response.indexOf("<!--")==0) {
            const end=response.indexOf("-->");
            if (end>0) {
                response=response.substr(4,end-4);
            }
        }
        if (response=='' || response==null || response==undefined) {
            return "Erreur inconnue ("+status+")";
        } else {
            return response;
        }
    }

    return {
        serializeObject,
        serializeArray,
        deserializeObject,
        validateNotEmpty,
        setFieldError,
        ajax,
        ajaxError,
        formatError
    }

})();