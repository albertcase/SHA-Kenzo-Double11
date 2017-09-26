/* Zepto v1.1.6 - zepto event ajax form ie - zeptojs.com/license */
var Zepto=function(){function L(t){return null==t?String(t):j[S.call(t)]||"object"}function Z(t){return"function"==L(t)}function _(t){return null!=t&&t==t.window}function $(t){return null!=t&&t.nodeType==t.DOCUMENT_NODE}function D(t){return"object"==L(t)}function M(t){return D(t)&&!_(t)&&Object.getPrototypeOf(t)==Object.prototype}function R(t){return"number"==typeof t.length}function k(t){return s.call(t,function(t){return null!=t})}function z(t){return t.length>0?n.fn.concat.apply([],t):t}function F(t){return t.replace(/::/g,"/").replace(/([A-Z]+)([A-Z][a-z])/g,"$1_$2").replace(/([a-z\d])([A-Z])/g,"$1_$2").replace(/_/g,"-").toLowerCase()}function q(t){return t in f?f[t]:f[t]=new RegExp("(^|\\s)"+t+"(\\s|$)")}function H(t,e){return"number"!=typeof e||c[F(t)]?e:e+"px"}function I(t){var e,n;return u[t]||(e=a.createElement(t),a.body.appendChild(e),n=getComputedStyle(e,"").getPropertyValue("display"),e.parentNode.removeChild(e),"none"==n&&(n="block"),u[t]=n),u[t]}function V(t){return"children"in t?o.call(t.children):n.map(t.childNodes,function(t){return 1==t.nodeType?t:void 0})}function B(n,i,r){for(e in i)r&&(M(i[e])||A(i[e]))?(M(i[e])&&!M(n[e])&&(n[e]={}),A(i[e])&&!A(n[e])&&(n[e]=[]),B(n[e],i[e],r)):i[e]!==t&&(n[e]=i[e])}function U(t,e){return null==e?n(t):n(t).filter(e)}function J(t,e,n,i){return Z(e)?e.call(t,n,i):e}function X(t,e,n){null==n?t.removeAttribute(e):t.setAttribute(e,n)}function W(e,n){var i=e.className||"",r=i&&i.baseVal!==t;return n===t?r?i.baseVal:i:void(r?i.baseVal=n:e.className=n)}function Y(t){try{return t?"true"==t||("false"==t?!1:"null"==t?null:+t+""==t?+t:/^[\[\{]/.test(t)?n.parseJSON(t):t):t}catch(e){return t}}function G(t,e){e(t);for(var n=0,i=t.childNodes.length;i>n;n++)G(t.childNodes[n],e)}var t,e,n,i,C,N,r=[],o=r.slice,s=r.filter,a=window.document,u={},f={},c={"column-count":1,columns:1,"font-weight":1,"line-height":1,opacity:1,"z-index":1,zoom:1},l=/^\s*<(\w+|!)[^>]*>/,h=/^<(\w+)\s*\/?>(?:<\/\1>|)$/,p=/<(?!area|br|col|embed|hr|img|input|link|meta|param)(([\w:]+)[^>]*)\/>/gi,d=/^(?:body|html)$/i,m=/([A-Z])/g,g=["val","css","html","text","data","width","height","offset"],v=["after","prepend","before","append"],y=a.createElement("table"),x=a.createElement("tr"),b={tr:a.createElement("tbody"),tbody:y,thead:y,tfoot:y,td:x,th:x,"*":a.createElement("div")},w=/complete|loaded|interactive/,E=/^[\w-]*$/,j={},S=j.toString,T={},O=a.createElement("div"),P={tabindex:"tabIndex",readonly:"readOnly","for":"htmlFor","class":"className",maxlength:"maxLength",cellspacing:"cellSpacing",cellpadding:"cellPadding",rowspan:"rowSpan",colspan:"colSpan",usemap:"useMap",frameborder:"frameBorder",contenteditable:"contentEditable"},A=Array.isArray||function(t){return t instanceof Array};return T.matches=function(t,e){if(!e||!t||1!==t.nodeType)return!1;var n=t.webkitMatchesSelector||t.mozMatchesSelector||t.oMatchesSelector||t.matchesSelector;if(n)return n.call(t,e);var i,r=t.parentNode,o=!r;return o&&(r=O).appendChild(t),i=~T.qsa(r,e).indexOf(t),o&&O.removeChild(t),i},C=function(t){return t.replace(/-+(.)?/g,function(t,e){return e?e.toUpperCase():""})},N=function(t){return s.call(t,function(e,n){return t.indexOf(e)==n})},T.fragment=function(e,i,r){var s,u,f;return h.test(e)&&(s=n(a.createElement(RegExp.$1))),s||(e.replace&&(e=e.replace(p,"<$1></$2>")),i===t&&(i=l.test(e)&&RegExp.$1),i in b||(i="*"),f=b[i],f.innerHTML=""+e,s=n.each(o.call(f.childNodes),function(){f.removeChild(this)})),M(r)&&(u=n(s),n.each(r,function(t,e){g.indexOf(t)>-1?u[t](e):u.attr(t,e)})),s},T.Z=function(t,e){return t=t||[],t.__proto__=n.fn,t.selector=e||"",t},T.isZ=function(t){return t instanceof T.Z},T.init=function(e,i){var r;if(!e)return T.Z();if("string"==typeof e)if(e=e.trim(),"<"==e[0]&&l.test(e))r=T.fragment(e,RegExp.$1,i),e=null;else{if(i!==t)return n(i).find(e);r=T.qsa(a,e)}else{if(Z(e))return n(a).ready(e);if(T.isZ(e))return e;if(A(e))r=k(e);else if(D(e))r=[e],e=null;else if(l.test(e))r=T.fragment(e.trim(),RegExp.$1,i),e=null;else{if(i!==t)return n(i).find(e);r=T.qsa(a,e)}}return T.Z(r,e)},n=function(t,e){return T.init(t,e)},n.extend=function(t){var e,n=o.call(arguments,1);return"boolean"==typeof t&&(e=t,t=n.shift()),n.forEach(function(n){B(t,n,e)}),t},T.qsa=function(t,e){var n,i="#"==e[0],r=!i&&"."==e[0],s=i||r?e.slice(1):e,a=E.test(s);return $(t)&&a&&i?(n=t.getElementById(s))?[n]:[]:1!==t.nodeType&&9!==t.nodeType?[]:o.call(a&&!i?r?t.getElementsByClassName(s):t.getElementsByTagName(e):t.querySelectorAll(e))},n.contains=a.documentElement.contains?function(t,e){return t!==e&&t.contains(e)}:function(t,e){for(;e&&(e=e.parentNode);)if(e===t)return!0;return!1},n.type=L,n.isFunction=Z,n.isWindow=_,n.isArray=A,n.isPlainObject=M,n.isEmptyObject=function(t){var e;for(e in t)return!1;return!0},n.inArray=function(t,e,n){return r.indexOf.call(e,t,n)},n.camelCase=C,n.trim=function(t){return null==t?"":String.prototype.trim.call(t)},n.uuid=0,n.support={},n.expr={},n.map=function(t,e){var n,r,o,i=[];if(R(t))for(r=0;r<t.length;r++)n=e(t[r],r),null!=n&&i.push(n);else for(o in t)n=e(t[o],o),null!=n&&i.push(n);return z(i)},n.each=function(t,e){var n,i;if(R(t)){for(n=0;n<t.length;n++)if(e.call(t[n],n,t[n])===!1)return t}else for(i in t)if(e.call(t[i],i,t[i])===!1)return t;return t},n.grep=function(t,e){return s.call(t,e)},window.JSON&&(n.parseJSON=JSON.parse),n.each("Boolean Number String Function Array Date RegExp Object Error".split(" "),function(t,e){j["[object "+e+"]"]=e.toLowerCase()}),n.fn={forEach:r.forEach,reduce:r.reduce,push:r.push,sort:r.sort,indexOf:r.indexOf,concat:r.concat,map:function(t){return n(n.map(this,function(e,n){return t.call(e,n,e)}))},slice:function(){return n(o.apply(this,arguments))},ready:function(t){return w.test(a.readyState)&&a.body?t(n):a.addEventListener("DOMContentLoaded",function(){t(n)},!1),this},get:function(e){return e===t?o.call(this):this[e>=0?e:e+this.length]},toArray:function(){return this.get()},size:function(){return this.length},remove:function(){return this.each(function(){null!=this.parentNode&&this.parentNode.removeChild(this)})},each:function(t){return r.every.call(this,function(e,n){return t.call(e,n,e)!==!1}),this},filter:function(t){return Z(t)?this.not(this.not(t)):n(s.call(this,function(e){return T.matches(e,t)}))},add:function(t,e){return n(N(this.concat(n(t,e))))},is:function(t){return this.length>0&&T.matches(this[0],t)},not:function(e){var i=[];if(Z(e)&&e.call!==t)this.each(function(t){e.call(this,t)||i.push(this)});else{var r="string"==typeof e?this.filter(e):R(e)&&Z(e.item)?o.call(e):n(e);this.forEach(function(t){r.indexOf(t)<0&&i.push(t)})}return n(i)},has:function(t){return this.filter(function(){return D(t)?n.contains(this,t):n(this).find(t).size()})},eq:function(t){return-1===t?this.slice(t):this.slice(t,+t+1)},first:function(){var t=this[0];return t&&!D(t)?t:n(t)},last:function(){var t=this[this.length-1];return t&&!D(t)?t:n(t)},find:function(t){var e,i=this;return e=t?"object"==typeof t?n(t).filter(function(){var t=this;return r.some.call(i,function(e){return n.contains(e,t)})}):1==this.length?n(T.qsa(this[0],t)):this.map(function(){return T.qsa(this,t)}):n()},closest:function(t,e){var i=this[0],r=!1;for("object"==typeof t&&(r=n(t));i&&!(r?r.indexOf(i)>=0:T.matches(i,t));)i=i!==e&&!$(i)&&i.parentNode;return n(i)},parents:function(t){for(var e=[],i=this;i.length>0;)i=n.map(i,function(t){return(t=t.parentNode)&&!$(t)&&e.indexOf(t)<0?(e.push(t),t):void 0});return U(e,t)},parent:function(t){return U(N(this.pluck("parentNode")),t)},children:function(t){return U(this.map(function(){return V(this)}),t)},contents:function(){return this.map(function(){return o.call(this.childNodes)})},siblings:function(t){return U(this.map(function(t,e){return s.call(V(e.parentNode),function(t){return t!==e})}),t)},empty:function(){return this.each(function(){this.innerHTML=""})},pluck:function(t){return n.map(this,function(e){return e[t]})},show:function(){return this.each(function(){"none"==this.style.display&&(this.style.display=""),"none"==getComputedStyle(this,"").getPropertyValue("display")&&(this.style.display=I(this.nodeName))})},replaceWith:function(t){return this.before(t).remove()},wrap:function(t){var e=Z(t);if(this[0]&&!e)var i=n(t).get(0),r=i.parentNode||this.length>1;return this.each(function(o){n(this).wrapAll(e?t.call(this,o):r?i.cloneNode(!0):i)})},wrapAll:function(t){if(this[0]){n(this[0]).before(t=n(t));for(var e;(e=t.children()).length;)t=e.first();n(t).append(this)}return this},wrapInner:function(t){var e=Z(t);return this.each(function(i){var r=n(this),o=r.contents(),s=e?t.call(this,i):t;o.length?o.wrapAll(s):r.append(s)})},unwrap:function(){return this.parent().each(function(){n(this).replaceWith(n(this).children())}),this},clone:function(){return this.map(function(){return this.cloneNode(!0)})},hide:function(){return this.css("display","none")},toggle:function(e){return this.each(function(){var i=n(this);(e===t?"none"==i.css("display"):e)?i.show():i.hide()})},prev:function(t){return n(this.pluck("previousElementSibling")).filter(t||"*")},next:function(t){return n(this.pluck("nextElementSibling")).filter(t||"*")},html:function(t){return 0 in arguments?this.each(function(e){var i=this.innerHTML;n(this).empty().append(J(this,t,e,i))}):0 in this?this[0].innerHTML:null},text:function(t){return 0 in arguments?this.each(function(e){var n=J(this,t,e,this.textContent);this.textContent=null==n?"":""+n}):0 in this?this[0].textContent:null},attr:function(n,i){var r;return"string"!=typeof n||1 in arguments?this.each(function(t){if(1===this.nodeType)if(D(n))for(e in n)X(this,e,n[e]);else X(this,n,J(this,i,t,this.getAttribute(n)))}):this.length&&1===this[0].nodeType?!(r=this[0].getAttribute(n))&&n in this[0]?this[0][n]:r:t},removeAttr:function(t){return this.each(function(){1===this.nodeType&&t.split(" ").forEach(function(t){X(this,t)},this)})},prop:function(t,e){return t=P[t]||t,1 in arguments?this.each(function(n){this[t]=J(this,e,n,this[t])}):this[0]&&this[0][t]},data:function(e,n){var i="data-"+e.replace(m,"-$1").toLowerCase(),r=1 in arguments?this.attr(i,n):this.attr(i);return null!==r?Y(r):t},val:function(t){return 0 in arguments?this.each(function(e){this.value=J(this,t,e,this.value)}):this[0]&&(this[0].multiple?n(this[0]).find("option").filter(function(){return this.selected}).pluck("value"):this[0].value)},offset:function(t){if(t)return this.each(function(e){var i=n(this),r=J(this,t,e,i.offset()),o=i.offsetParent().offset(),s={top:r.top-o.top,left:r.left-o.left};"static"==i.css("position")&&(s.position="relative"),i.css(s)});if(!this.length)return null;var e=this[0].getBoundingClientRect();return{left:e.left+window.pageXOffset,top:e.top+window.pageYOffset,width:Math.round(e.width),height:Math.round(e.height)}},css:function(t,i){if(arguments.length<2){var r,o=this[0];if(!o)return;if(r=getComputedStyle(o,""),"string"==typeof t)return o.style[C(t)]||r.getPropertyValue(t);if(A(t)){var s={};return n.each(t,function(t,e){s[e]=o.style[C(e)]||r.getPropertyValue(e)}),s}}var a="";if("string"==L(t))i||0===i?a=F(t)+":"+H(t,i):this.each(function(){this.style.removeProperty(F(t))});else for(e in t)t[e]||0===t[e]?a+=F(e)+":"+H(e,t[e])+";":this.each(function(){this.style.removeProperty(F(e))});return this.each(function(){this.style.cssText+=";"+a})},index:function(t){return t?this.indexOf(n(t)[0]):this.parent().children().indexOf(this[0])},hasClass:function(t){return t?r.some.call(this,function(t){return this.test(W(t))},q(t)):!1},addClass:function(t){return t?this.each(function(e){if("className"in this){i=[];var r=W(this),o=J(this,t,e,r);o.split(/\s+/g).forEach(function(t){n(this).hasClass(t)||i.push(t)},this),i.length&&W(this,r+(r?" ":"")+i.join(" "))}}):this},removeClass:function(e){return this.each(function(n){if("className"in this){if(e===t)return W(this,"");i=W(this),J(this,e,n,i).split(/\s+/g).forEach(function(t){i=i.replace(q(t)," ")}),W(this,i.trim())}})},toggleClass:function(e,i){return e?this.each(function(r){var o=n(this),s=J(this,e,r,W(this));s.split(/\s+/g).forEach(function(e){(i===t?!o.hasClass(e):i)?o.addClass(e):o.removeClass(e)})}):this},scrollTop:function(e){if(this.length){var n="scrollTop"in this[0];return e===t?n?this[0].scrollTop:this[0].pageYOffset:this.each(n?function(){this.scrollTop=e}:function(){this.scrollTo(this.scrollX,e)})}},scrollLeft:function(e){if(this.length){var n="scrollLeft"in this[0];return e===t?n?this[0].scrollLeft:this[0].pageXOffset:this.each(n?function(){this.scrollLeft=e}:function(){this.scrollTo(e,this.scrollY)})}},position:function(){if(this.length){var t=this[0],e=this.offsetParent(),i=this.offset(),r=d.test(e[0].nodeName)?{top:0,left:0}:e.offset();return i.top-=parseFloat(n(t).css("margin-top"))||0,i.left-=parseFloat(n(t).css("margin-left"))||0,r.top+=parseFloat(n(e[0]).css("border-top-width"))||0,r.left+=parseFloat(n(e[0]).css("border-left-width"))||0,{top:i.top-r.top,left:i.left-r.left}}},offsetParent:function(){return this.map(function(){for(var t=this.offsetParent||a.body;t&&!d.test(t.nodeName)&&"static"==n(t).css("position");)t=t.offsetParent;return t})}},n.fn.detach=n.fn.remove,["width","height"].forEach(function(e){var i=e.replace(/./,function(t){return t[0].toUpperCase()});n.fn[e]=function(r){var o,s=this[0];return r===t?_(s)?s["inner"+i]:$(s)?s.documentElement["scroll"+i]:(o=this.offset())&&o[e]:this.each(function(t){s=n(this),s.css(e,J(this,r,t,s[e]()))})}}),v.forEach(function(t,e){var i=e%2;n.fn[t]=function(){var t,o,r=n.map(arguments,function(e){return t=L(e),"object"==t||"array"==t||null==e?e:T.fragment(e)}),s=this.length>1;return r.length<1?this:this.each(function(t,u){o=i?u:u.parentNode,u=0==e?u.nextSibling:1==e?u.firstChild:2==e?u:null;var f=n.contains(a.documentElement,o);r.forEach(function(t){if(s)t=t.cloneNode(!0);else if(!o)return n(t).remove();o.insertBefore(t,u),f&&G(t,function(t){null==t.nodeName||"SCRIPT"!==t.nodeName.toUpperCase()||t.type&&"text/javascript"!==t.type||t.src||window.eval.call(window,t.innerHTML)})})})},n.fn[i?t+"To":"insert"+(e?"Before":"After")]=function(e){return n(e)[t](this),this}}),T.Z.prototype=n.fn,T.uniq=N,T.deserializeValue=Y,n.zepto=T,n}();window.Zepto=Zepto,void 0===window.$&&(window.$=Zepto),function(t){function l(t){return t._zid||(t._zid=e++)}function h(t,e,n,i){if(e=p(e),e.ns)var r=d(e.ns);return(s[l(t)]||[]).filter(function(t){return!(!t||e.e&&t.e!=e.e||e.ns&&!r.test(t.ns)||n&&l(t.fn)!==l(n)||i&&t.sel!=i)})}function p(t){var e=(""+t).split(".");return{e:e[0],ns:e.slice(1).sort().join(" ")}}function d(t){return new RegExp("(?:^| )"+t.replace(" "," .* ?")+"(?: |$)")}function m(t,e){return t.del&&!u&&t.e in f||!!e}function g(t){return c[t]||u&&f[t]||t}function v(e,i,r,o,a,u,f){var h=l(e),d=s[h]||(s[h]=[]);i.split(/\s/).forEach(function(i){if("ready"==i)return t(document).ready(r);var s=p(i);s.fn=r,s.sel=a,s.e in c&&(r=function(e){var n=e.relatedTarget;return!n||n!==this&&!t.contains(this,n)?s.fn.apply(this,arguments):void 0}),s.del=u;var l=u||r;s.proxy=function(t){if(t=j(t),!t.isImmediatePropagationStopped()){t.data=o;var i=l.apply(e,t._args==n?[t]:[t].concat(t._args));return i===!1&&(t.preventDefault(),t.stopPropagation()),i}},s.i=d.length,d.push(s),"addEventListener"in e&&e.addEventListener(g(s.e),s.proxy,m(s,f))})}function y(t,e,n,i,r){var o=l(t);(e||"").split(/\s/).forEach(function(e){h(t,e,n,i).forEach(function(e){delete s[o][e.i],"removeEventListener"in t&&t.removeEventListener(g(e.e),e.proxy,m(e,r))})})}function j(e,i){return(i||!e.isDefaultPrevented)&&(i||(i=e),t.each(E,function(t,n){var r=i[t];e[t]=function(){return this[n]=x,r&&r.apply(i,arguments)},e[n]=b}),(i.defaultPrevented!==n?i.defaultPrevented:"returnValue"in i?i.returnValue===!1:i.getPreventDefault&&i.getPreventDefault())&&(e.isDefaultPrevented=x)),e}function S(t){var e,i={originalEvent:t};for(e in t)w.test(e)||t[e]===n||(i[e]=t[e]);return j(i,t)}var n,e=1,i=Array.prototype.slice,r=t.isFunction,o=function(t){return"string"==typeof t},s={},a={},u="onfocusin"in window,f={focus:"focusin",blur:"focusout"},c={mouseenter:"mouseover",mouseleave:"mouseout"};a.click=a.mousedown=a.mouseup=a.mousemove="MouseEvents",t.event={add:v,remove:y},t.proxy=function(e,n){var s=2 in arguments&&i.call(arguments,2);if(r(e)){var a=function(){return e.apply(n,s?s.concat(i.call(arguments)):arguments)};return a._zid=l(e),a}if(o(n))return s?(s.unshift(e[n],e),t.proxy.apply(null,s)):t.proxy(e[n],e);throw new TypeError("expected function")},t.fn.bind=function(t,e,n){return this.on(t,e,n)},t.fn.unbind=function(t,e){return this.off(t,e)},t.fn.one=function(t,e,n,i){return this.on(t,e,n,i,1)};var x=function(){return!0},b=function(){return!1},w=/^([A-Z]|returnValue$|layer[XY]$)/,E={preventDefault:"isDefaultPrevented",stopImmediatePropagation:"isImmediatePropagationStopped",stopPropagation:"isPropagationStopped"};t.fn.delegate=function(t,e,n){return this.on(e,t,n)},t.fn.undelegate=function(t,e,n){return this.off(e,t,n)},t.fn.live=function(e,n){return t(document.body).delegate(this.selector,e,n),this},t.fn.die=function(e,n){return t(document.body).undelegate(this.selector,e,n),this},t.fn.on=function(e,s,a,u,f){var c,l,h=this;return e&&!o(e)?(t.each(e,function(t,e){h.on(t,s,a,e,f)}),h):(o(s)||r(u)||u===!1||(u=a,a=s,s=n),(r(a)||a===!1)&&(u=a,a=n),u===!1&&(u=b),h.each(function(n,r){f&&(c=function(t){return y(r,t.type,u),u.apply(this,arguments)}),s&&(l=function(e){var n,o=t(e.target).closest(s,r).get(0);return o&&o!==r?(n=t.extend(S(e),{currentTarget:o,liveFired:r}),(c||u).apply(o,[n].concat(i.call(arguments,1)))):void 0}),v(r,e,u,a,s,l||c)}))},t.fn.off=function(e,i,s){var a=this;return e&&!o(e)?(t.each(e,function(t,e){a.off(t,i,e)}),a):(o(i)||r(s)||s===!1||(s=i,i=n),s===!1&&(s=b),a.each(function(){y(this,e,s,i)}))},t.fn.trigger=function(e,n){return e=o(e)||t.isPlainObject(e)?t.Event(e):j(e),e._args=n,this.each(function(){e.type in f&&"function"==typeof this[e.type]?this[e.type]():"dispatchEvent"in this?this.dispatchEvent(e):t(this).triggerHandler(e,n)})},t.fn.triggerHandler=function(e,n){var i,r;return this.each(function(s,a){i=S(o(e)?t.Event(e):e),i._args=n,i.target=a,t.each(h(a,e.type||e),function(t,e){return r=e.proxy(i),i.isImmediatePropagationStopped()?!1:void 0})}),r},"focusin focusout focus blur load resize scroll unload click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select keydown keypress keyup error".split(" ").forEach(function(e){t.fn[e]=function(t){return 0 in arguments?this.bind(e,t):this.trigger(e)}}),t.Event=function(t,e){o(t)||(e=t,t=e.type);var n=document.createEvent(a[t]||"Events"),i=!0;if(e)for(var r in e)"bubbles"==r?i=!!e[r]:n[r]=e[r];return n.initEvent(t,i,!0),j(n)}}(Zepto),function(t){function h(e,n,i){var r=t.Event(n);return t(e).trigger(r,i),!r.isDefaultPrevented()}function p(t,e,i,r){return t.global?h(e||n,i,r):void 0}function d(e){e.global&&0===t.active++&&p(e,null,"ajaxStart")}function m(e){e.global&&!--t.active&&p(e,null,"ajaxStop")}function g(t,e){var n=e.context;return e.beforeSend.call(n,t,e)===!1||p(e,n,"ajaxBeforeSend",[t,e])===!1?!1:void p(e,n,"ajaxSend",[t,e])}function v(t,e,n,i){var r=n.context,o="success";n.success.call(r,t,o,e),i&&i.resolveWith(r,[t,o,e]),p(n,r,"ajaxSuccess",[e,n,t]),x(o,e,n)}function y(t,e,n,i,r){var o=i.context;i.error.call(o,n,e,t),r&&r.rejectWith(o,[n,e,t]),p(i,o,"ajaxError",[n,i,t||e]),x(e,n,i)}function x(t,e,n){var i=n.context;n.complete.call(i,e,t),p(n,i,"ajaxComplete",[e,n]),m(n)}function b(){}function w(t){return t&&(t=t.split(";",2)[0]),t&&(t==f?"html":t==u?"json":s.test(t)?"script":a.test(t)&&"xml")||"text"}function E(t,e){return""==e?t:(t+"&"+e).replace(/[&?]{1,2}/,"?")}function j(e){e.processData&&e.data&&"string"!=t.type(e.data)&&(e.data=t.param(e.data,e.traditional)),!e.data||e.type&&"GET"!=e.type.toUpperCase()||(e.url=E(e.url,e.data),e.data=void 0)}function S(e,n,i,r){return t.isFunction(n)&&(r=i,i=n,n=void 0),t.isFunction(i)||(r=i,i=void 0),{url:e,data:n,success:i,dataType:r}}function C(e,n,i,r){var o,s=t.isArray(n),a=t.isPlainObject(n);t.each(n,function(n,u){o=t.type(u),r&&(n=i?r:r+"["+(a||"object"==o||"array"==o?n:"")+"]"),!r&&s?e.add(u.name,u.value):"array"==o||!i&&"object"==o?C(e,u,i,n):e.add(n,u)})}var i,r,e=0,n=window.document,o=/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi,s=/^(?:text|application)\/javascript/i,a=/^(?:text|application)\/xml/i,u="application/json",f="text/html",c=/^\s*$/,l=n.createElement("a");l.href=window.location.href,t.active=0,t.ajaxJSONP=function(i,r){if(!("type"in i))return t.ajax(i);var f,h,o=i.jsonpCallback,s=(t.isFunction(o)?o():o)||"jsonp"+ ++e,a=n.createElement("script"),u=window[s],c=function(e){t(a).triggerHandler("error",e||"abort")},l={abort:c};return r&&r.promise(l),t(a).on("load error",function(e,n){clearTimeout(h),t(a).off().remove(),"error"!=e.type&&f?v(f[0],l,i,r):y(null,n||"error",l,i,r),window[s]=u,f&&t.isFunction(u)&&u(f[0]),u=f=void 0}),g(l,i)===!1?(c("abort"),l):(window[s]=function(){f=arguments},a.src=i.url.replace(/\?(.+)=\?/,"?$1="+s),n.head.appendChild(a),i.timeout>0&&(h=setTimeout(function(){c("timeout")},i.timeout)),l)},t.ajaxSettings={type:"GET",beforeSend:b,success:b,error:b,complete:b,context:null,global:!0,xhr:function(){return new window.XMLHttpRequest},accepts:{script:"text/javascript, application/javascript, application/x-javascript",json:u,xml:"application/xml, text/xml",html:f,text:"text/plain"},crossDomain:!1,timeout:0,processData:!0,cache:!0},t.ajax=function(e){var a,o=t.extend({},e||{}),s=t.Deferred&&t.Deferred();for(i in t.ajaxSettings)void 0===o[i]&&(o[i]=t.ajaxSettings[i]);d(o),o.crossDomain||(a=n.createElement("a"),a.href=o.url,a.href=a.href,o.crossDomain=l.protocol+"//"+l.host!=a.protocol+"//"+a.host),o.url||(o.url=window.location.toString()),j(o);var u=o.dataType,f=/\?.+=\?/.test(o.url);if(f&&(u="jsonp"),o.cache!==!1&&(e&&e.cache===!0||"script"!=u&&"jsonp"!=u)||(o.url=E(o.url,"_="+Date.now())),"jsonp"==u)return f||(o.url=E(o.url,o.jsonp?o.jsonp+"=?":o.jsonp===!1?"":"callback=?")),t.ajaxJSONP(o,s);var C,h=o.accepts[u],p={},m=function(t,e){p[t.toLowerCase()]=[t,e]},x=/^([\w-]+:)\/\//.test(o.url)?RegExp.$1:window.location.protocol,S=o.xhr(),T=S.setRequestHeader;if(s&&s.promise(S),o.crossDomain||m("X-Requested-With","XMLHttpRequest"),m("Accept",h||"*/*"),(h=o.mimeType||h)&&(h.indexOf(",")>-1&&(h=h.split(",",2)[0]),S.overrideMimeType&&S.overrideMimeType(h)),(o.contentType||o.contentType!==!1&&o.data&&"GET"!=o.type.toUpperCase())&&m("Content-Type",o.contentType||"application/x-www-form-urlencoded"),o.headers)for(r in o.headers)m(r,o.headers[r]);if(S.setRequestHeader=m,S.onreadystatechange=function(){if(4==S.readyState){S.onreadystatechange=b,clearTimeout(C);var e,n=!1;if(S.status>=200&&S.status<300||304==S.status||0==S.status&&"file:"==x){u=u||w(o.mimeType||S.getResponseHeader("content-type")),e=S.responseText;try{"script"==u?(1,eval)(e):"xml"==u?e=S.responseXML:"json"==u&&(e=c.test(e)?null:t.parseJSON(e))}catch(i){n=i}n?y(n,"parsererror",S,o,s):v(e,S,o,s)}else y(S.statusText||null,S.status?"error":"abort",S,o,s)}},g(S,o)===!1)return S.abort(),y(null,"abort",S,o,s),S;if(o.xhrFields)for(r in o.xhrFields)S[r]=o.xhrFields[r];var N="async"in o?o.async:!0;S.open(o.type,o.url,N,o.username,o.password);for(r in p)T.apply(S,p[r]);return o.timeout>0&&(C=setTimeout(function(){S.onreadystatechange=b,S.abort(),y(null,"timeout",S,o,s)},o.timeout)),S.send(o.data?o.data:null),S},t.get=function(){return t.ajax(S.apply(null,arguments))},t.post=function(){var e=S.apply(null,arguments);return e.type="POST",t.ajax(e)},t.getJSON=function(){var e=S.apply(null,arguments);return e.dataType="json",t.ajax(e)},t.fn.load=function(e,n,i){if(!this.length)return this;var a,r=this,s=e.split(/\s/),u=S(e,n,i),f=u.success;return s.length>1&&(u.url=s[0],a=s[1]),u.success=function(e){r.html(a?t("<div>").html(e.replace(o,"")).find(a):e),f&&f.apply(r,arguments)},t.ajax(u),this};var T=encodeURIComponent;t.param=function(e,n){var i=[];return i.add=function(e,n){t.isFunction(n)&&(n=n()),null==n&&(n=""),this.push(T(e)+"="+T(n))},C(i,e,n),i.join("&").replace(/%20/g,"+")}}(Zepto),function(t){t.fn.serializeArray=function(){var e,n,i=[],r=function(t){return t.forEach?t.forEach(r):void i.push({name:e,value:t})};return this[0]&&t.each(this[0].elements,function(i,o){n=o.type,e=o.name,e&&"fieldset"!=o.nodeName.toLowerCase()&&!o.disabled&&"submit"!=n&&"reset"!=n&&"button"!=n&&"file"!=n&&("radio"!=n&&"checkbox"!=n||o.checked)&&r(t(o).val())}),i},t.fn.serialize=function(){var t=[];return this.serializeArray().forEach(function(e){t.push(encodeURIComponent(e.name)+"="+encodeURIComponent(e.value))}),t.join("&")},t.fn.submit=function(e){if(0 in arguments)this.bind("submit",e);else if(this.length){var n=t.Event("submit");this.eq(0).trigger(n),n.isDefaultPrevented()||this.get(0).submit()}return this}}(Zepto),function(t){"__proto__"in{}||t.extend(t.zepto,{Z:function(e,n){return e=e||[],t.extend(e,t.fn),e.selector=n||"",e.__Z=!0,e},isZ:function(e){return"array"===t.type(e)&&"__Z"in e}});try{getComputedStyle(void 0)}catch(e){var n=getComputedStyle;window.getComputedStyle=function(t){try{return n(t)}catch(e){return null}}}}(Zepto);
;(function(){
	'use strict';

	// can we support addEventListener
	var hasNative = 'addEventListener' in (new Image());

	var preLoader = function(images, options){
		this.options = {
			pipeline: false,
			auto: true,
			prefetch: false,
			/* onProgress: function(){}, */
			/* onError: function(){}, */
			onComplete: function(){}
		};

		options && typeof options == 'object' && this.setOptions(options);

		this.addQueue(images);
		this.queue.length && this.options.auto && this.processQueue();
	};

	preLoader.prototype.setOptions = function(options){
		// shallow copy
		var o = this.options,
			key;

		for (key in options) options.hasOwnProperty(key) && (o[key] = options[key]);

		return this;
	};

	preLoader.prototype.addQueue = function(images){
		// stores a local array, dereferenced from original
		this.queue = images.slice();

		return this;
	};

	preLoader.prototype.reset = function(){
		// reset the arrays
		this.completed = [];
		this.errors = [];

		return this;
	};

	preLoader.prototype.addEvents = function(image, src, index){
		var self = this,
			o = this.options,
			cleanup = function(){
				if (hasNative){
					this.removeEventListener('error', abort);
					this.removeEventListener('abort', abort);
					this.removeEventListener('load', load);
				}
				else {
					this.onerror = this.onabort = this.onload = null;
				}
			},
			abort = function(){
				//console.log('src error:' + src);
				cleanup.call(this);

				self.errors.push(src);
				o.onError && o.onError.call(self, src);
				checkProgress.call(self, src);
				o.pipeline && self.loadNext(index);
			},
			load = function(){
				//console.log('src load:' + src);
				cleanup.call(this);

				// store progress. this === image
				self.completed.push(src); // this.src may differ
				checkProgress.call(self, src, this);
				o.pipeline && self.loadNext(index);
			};

		if (hasNative){
			image.addEventListener('error', abort, false);
			image.addEventListener('abort', abort, false);
			image.addEventListener('load', load, false);
		}
		else {
			image.onerror = image.onabort = abort;
			image.onload = load;
		}

	};

	preLoader.prototype.load = function(src, index){
		/*jshint -W058 */
		var image = new Image;

		this.addEvents(image, src, index);

		// actually load
		image.src = src;

		return this;
	};

	preLoader.prototype.loadNext = function(index){
		// when pipeline loading is enabled, calls next item
		index++;
		this.queue[index] && this.load(this.queue[index], index);

		return this;
	};

	preLoader.prototype.processQueue = function(){
		// runs through all queued items.
		var i = 0,
			queue = this.queue,
			len = queue.length;

		// process all queue items
		this.reset();

		if (!this.options.pipeline) for (; i < len; ++i) this.load(queue[i], i);
		else this.load(queue[0], 0);

		return this;
	};

	/*jshint validthis:true */
	function checkProgress(src, image){
		// intermediate checker for queue remaining. not exported.
		// called on preLoader instance as scope
		var args = [],
			o = this.options;

		// call onProgress
		o.onProgress && src && o.onProgress.call(this, src, image, this.completed.length);

		if (this.completed.length + this.errors.length === this.queue.length){
			args.push(this.completed);
			this.errors.length && args.push(this.errors);
			o.onComplete.apply(this, args);
		}

		return this;
	}
	/*jshint validthis:false */

	if (typeof define === 'function' && define.amd){
		// we have an AMD loader.
		define(function(){
			return preLoader;
		});
	}
	else {
		this.preLoader = preLoader;
	}
}).call(this);

/*!
 * JavaScript Cookie v2.1.4
 * https://github.com/js-cookie/js-cookie
 *
 * Copyright 2006, 2015 Klaus Hartl & Fagner Brack
 * Released under the MIT license
 */
;(function (factory) {
    var registeredInModuleLoader = false;
    if (typeof define === 'function' && define.amd) {
        define(factory);
        registeredInModuleLoader = true;
    }
    if (typeof exports === 'object') {
        module.exports = factory();
        registeredInModuleLoader = true;
    }
    if (!registeredInModuleLoader) {
        var OldCookies = window.Cookies;
        var api = window.Cookies = factory();
        api.noConflict = function () {
            window.Cookies = OldCookies;
            return api;
        };
    }
}(function () {
    function extend () {
        var i = 0;
        var result = {};
        for (; i < arguments.length; i++) {
            var attributes = arguments[ i ];
            for (var key in attributes) {
                result[key] = attributes[key];
            }
        }
        return result;
    }

    function init (converter) {
        function api (key, value, attributes) {
            var result;
            if (typeof document === 'undefined') {
                return;
            }

            // Write

            if (arguments.length > 1) {
                attributes = extend({
                    path: '/'
                }, api.defaults, attributes);

                if (typeof attributes.expires === 'number') {
                    var expires = new Date();
                    expires.setMilliseconds(expires.getMilliseconds() + attributes.expires * 864e+5);
                    attributes.expires = expires;
                }

                // We're using "expires" because "max-age" is not supported by IE
                attributes.expires = attributes.expires ? attributes.expires.toUTCString() : '';

                try {
                    result = JSON.stringify(value);
                    if (/^[\{\[]/.test(result)) {
                        value = result;
                    }
                } catch (e) {}

                if (!converter.write) {
                    value = encodeURIComponent(String(value))
                        .replace(/%(23|24|26|2B|3A|3C|3E|3D|2F|3F|40|5B|5D|5E|60|7B|7D|7C)/g, decodeURIComponent);
                } else {
                    value = converter.write(value, key);
                }

                key = encodeURIComponent(String(key));
                key = key.replace(/%(23|24|26|2B|5E|60|7C)/g, decodeURIComponent);
                key = key.replace(/[\(\)]/g, escape);

                var stringifiedAttributes = '';

                for (var attributeName in attributes) {
                    if (!attributes[attributeName]) {
                        continue;
                    }
                    stringifiedAttributes += '; ' + attributeName;
                    if (attributes[attributeName] === true) {
                        continue;
                    }
                    stringifiedAttributes += '=' + attributes[attributeName];
                }
                return (document.cookie = key + '=' + value + stringifiedAttributes);
            }

            // Read

            if (!key) {
                result = {};
            }

            // To prevent the for loop in the first place assign an empty array
            // in case there are no cookies at all. Also prevents odd result when
            // calling "get()"
            var cookies = document.cookie ? document.cookie.split('; ') : [];
            var rdecode = /(%[0-9A-Z]{2})+/g;
            var i = 0;

            for (; i < cookies.length; i++) {
                var parts = cookies[i].split('=');
                var cookie = parts.slice(1).join('=');

                if (cookie.charAt(0) === '"') {
                    cookie = cookie.slice(1, -1);
                }

                try {
                    var name = parts[0].replace(rdecode, decodeURIComponent);
                    cookie = converter.read ?
                        converter.read(cookie, name) : converter(cookie, name) ||
                    cookie.replace(rdecode, decodeURIComponent);

                    if (this.json) {
                        try {
                            cookie = JSON.parse(cookie);
                        } catch (e) {}
                    }

                    if (key === name) {
                        result = cookie;
                        break;
                    }

                    if (!key) {
                        result[name] = cookie;
                    }
                } catch (e) {}
            }

            return result;
        }

        api.set = api;
        api.get = function (key) {
            return api.call(api, key);
        };
        api.getJSON = function () {
            return api.apply({
                json: true
            }, [].slice.call(arguments));
        };
        api.defaults = {};

        api.remove = function (key, attributes) {
            api(key, '', extend(attributes, {
                expires: -1
            }));
        };

        api.withConverter = init;

        return api;
    }

    return init(function () {});
}));
(function(doc, win) {
    var docEl = doc.documentElement,
    isIOS = navigator.userAgent.match(/iphone|ipod|ipad/gi),
    dpr = isIOS? Math.min(win.devicePixelRatio, 3) : 1,
    scale = 1 / dpr,
    resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize';
    //fix iphone plus bug
    if(dpr == 3){
        scale=1;
        dpr = 2;
    }
    docEl.dataset.dpr = dpr;
    //var metaEl = doc.createElement('meta');
    //metaEl.name = 'viewport';
    //metaEl.content = 'initial-scale=' + scale + ', maximum-scale=' + scale + ', minimum-scale=' + scale;
    //docEl.firstElementChild.appendChild(metaEl);
    var recalc = function () {
        var width = docEl.clientWidth,
			height = docEl.clientHeight;
        if (width / dpr > 750) {
            width = 750 * dpr;
        }
				if(width/height>750/1207){
					docEl.style.fontSize = 100 * (height / 1207) + 'px';

				}else{
					docEl.style.fontSize = 100 * (width / 750) + 'px';
				}
      };
    recalc();
    if (!doc.addEventListener) return;
    win.addEventListener(resizeEvt, recalc, false);
})(document, window);
var region = [
    {
        name:'省份',"city":[{"name":"城市","area":["区县"]}]
    },
    { "name": "北京", "city":[{"name":"北京", "area":["东城区","西城区","崇文区","宣武区","朝阳区","丰台区","石景山区","海淀区","门头沟区","房山区","通州区","顺义区","昌平区","大兴区","平谷区","怀柔区","密云县","延庆县"]}]},

    { "name": "天津", "city":[{"name":"天津", "area":["和平区","河东区","河西区","南开区","河北区","红桥区","塘沽区","汉沽区","大港区","东丽区","西青区","津南区","北辰区","武清区","宝坻区","宁河县","静海县","蓟  县"]}]},

    { "name": "河北", "city":[

        {"name":"石家庄", "area":["长安区","桥东区","桥西区","新华区","郊  区","井陉矿区","井陉县","正定县","栾城县","行唐县","灵寿县","高邑县","深泽县","赞皇县","无极县","平山县","元氏县","赵  县","辛集市","藁","晋州市","新乐市","鹿泉市"]},

        {"name":"唐山", "area":["路南区","路北区","古冶区","开平区","新  区","丰润县","滦  县","滦南县","乐亭县","迁西县","玉田县","唐海县","遵化市","丰南市","迁安市"]},

        {"name":"秦皇岛", "area":["海港区","山海关区","北戴河区","青龙满族自治县","昌黎县","抚宁县","卢龙县"]},

        {"name":"邯郸", "area":["邯山区","丛台区","复兴区","峰峰矿区","邯郸县","临漳县","成安县","大名县","涉  县","磁  县","肥乡县","永年县","邱  县","鸡泽县","广平县","馆陶县","魏  县","曲周县","武安市"]},

        {"name":"邢台", "area":["桥东区","桥西区","邢台县","临城县","内丘县","柏乡县","隆尧县","任  县","南和县","宁晋县","巨鹿县","新河县","广宗县","平乡县","威  县","清河县","临西县","南宫市","沙河市"]},

        {"name":"保定", "area":["新市区","北市区","南市区","满城县","清苑县","涞水县","阜平县","徐水县","定兴县","唐  县","高阳县","容城县","涞源县","望都县","安新县","易  县","曲阳县","蠡  县","顺平县","博野","雄县","涿州市","定州市","安国市","高碑店市"]},

        {"name":"张家口", "area":["桥东区","桥西区","宣化区","下花园区","宣化县","张北县","康保县","沽源县","尚义县","蔚  县","阳原县","怀安县","万全县","怀来县","涿鹿县","赤城县","崇礼县"]},

        {"name":"承德", "area":["双桥区","双滦区","鹰手营子矿区","承德县","兴隆县","平泉县","滦平县","隆化县","丰宁满族自治县","宽城满族自治县","围场满族蒙古族自治县"]},

        {"name":"沧州", "area":["新华区","运河区","沧  县","青  县","东光县","海兴县","盐山县","肃宁县","南皮县","吴桥县","献  县","孟村回族自治县","泊头市","任丘市","黄骅市","河间市"]},

        {"name":"廊坊", "area":["安次区","固安县","永清县","香河县","大城县","文安县","大厂回族自治县","霸州市","三河市"]},

        {"name":"衡水", "area":["桃城区","枣强县","武邑县","武强县","饶阳县","安平县","故城县","景  县","阜城县","冀州市","深州市"]}

    ]},

    { "name": "山西", "city":[

        {"name":"太原", "area":["小店区","迎泽区","杏花岭区","尖草坪区","万柏林区","晋源区","清徐县","阳曲县","娄烦县","古交市"]},

        {"name":"大同", "area":["城  区","矿  区","南郊区","新荣区","阳高县","天镇县","广灵县","灵丘县","浑源县","左云县","大同县"]},

        {"name":"阳泉", "area":["城  区","矿  区","郊  区","平定县","盂  县"]},

        {"name":"长治", "area":["城  区","郊  区","长治县","襄垣县","屯留县","平顺县","黎城县","壶关县","长子县","武乡县","沁  县","沁源县","潞城市"]},

        {"name":"晋城", "area":["城  区","沁水县","阳城县","陵川县","泽州县","高平市"]},

        {"name":"朔州", "area":["朔城区","平鲁区","山阴县","应  县","右玉县","怀仁县"]},

        {"name":"忻州", "area":["忻府区","原平市","定襄县","五台县","代  县","繁峙县","宁武县","静乐县","神池县","五寨县","岢岚县","河曲县","保德县","偏关县"]},

        {"name":"吕梁", "area":["离石区","孝义市","汾阳市","文水县","交城县","兴  县","临  县","柳林县","石楼县","岚  县","方山县","中阳县","交口县"]},

        {"name":"晋中", "area":["榆次市","介休市","榆社县","左权县","和顺县","昔阳县","寿阳县","太谷县","祁  县","平遥县","灵石县"]},

        {"name":"临汾", "area":["临汾市","侯马市","霍州市","曲沃县","翼城县","襄汾县","洪洞县","古  县","安泽县","浮山县","吉  县","乡宁县","蒲  县","大宁县","永和县","隰  县","汾西县"]},

        {"name":"运城", "area":["运城市","永济市","河津市","芮城县","临猗县","万荣县","新绛县","稷山县","闻喜县","夏  县","绛  县","平陆县","垣曲县"]}

    ]},

    { "name": "内蒙古", "city":[

        {"name":"呼和浩特", "area":["新城区","回民区","玉泉区","郊  区","土默特左旗","托克托县","和林格尔县","清水河县","武川县"]},

        {"name":"包头", "area":["东河区","昆都伦区","青山区","石拐矿区","白云矿区","郊  区","土默特右旗","固阳县","达尔罕茂明安联合旗"]},

        {"name":"乌海", "area":["海勃湾区","海南区","乌达区"]},

        {"name":"赤峰", "area":["红山区","元宝山区","松山区","阿鲁科尔沁旗","巴林左旗","巴林右旗","林西县","克什克腾旗","翁牛特旗","喀喇沁旗","宁城县","敖汉旗"]},

        {"name":"呼伦贝尔", "area":["海拉尔市","满洲里市","扎兰屯市","牙克石市","根河市","额尔古纳市","阿荣旗","莫力达瓦达斡尔族自治旗","鄂伦春自治旗","鄂温克族自治旗","新巴尔虎右旗","新巴尔虎左旗","陈巴尔虎旗"]},

        {"name":"兴安盟", "area":["乌兰浩特市","阿尔山市","科尔沁右翼前旗","科尔沁右翼中旗","扎赉特旗","突泉县"]},

        {"name":"通辽", "area":["科尔沁区","霍林郭勒市","科尔沁左翼中旗","科尔沁左翼后旗","开鲁县","库伦旗","奈曼旗","扎鲁特旗"]},

        {"name":"锡林郭勒盟", "area":["二连浩特市","锡林浩特市","阿巴嘎旗","苏尼特左旗","苏尼特右旗","东乌珠穆沁旗","西乌珠穆沁旗","太仆寺旗","镶黄旗","正镶白旗","正蓝旗","多伦县"]},

        {"name":"乌兰察布盟", "area":["集宁市","丰镇市","卓资县","化德县","商都县","兴和县","凉城县","察哈尔右翼前旗","察哈尔右翼中旗","察哈尔右翼后旗","四子王旗"]},

        {"name":"伊克昭盟", "area":["东胜市","达拉特旗","准格尔旗","鄂托克前旗","鄂托克旗","杭锦旗","乌审旗","伊金霍洛旗"]},

        {"name":"巴彦淖尔盟", "area":["临河市","五原县","磴口县","乌拉特前旗","乌拉特中旗","乌拉特后旗","杭锦后旗"]},

        {"name":"阿拉善盟", "area":["阿拉善左旗","阿拉善右旗","额济纳旗"]}

    ]},

    { "name": "辽宁", "city":[

        {"name":"沈阳", "area":["沈河区","皇姑区","和平区","大东区","铁西区","苏家屯区","东陵区","于洪区","新民市","法库县","辽中县","康平县","新城子区","其他"]},

        {"name":"大连", "area":["西岗区","中山区","沙河口区","甘井子区","旅顺口区","金州区","瓦房店市","普兰店市","庄河市","长海县","其他"]},

        {"name":"鞍山", "area":["铁东区","铁西区","立山区","千山区","海城市","台安县","岫岩满族自治县","其他"]},

        {"name":"抚顺", "area":["顺城区","新抚区","东洲区","望花区","抚顺县","清原满族自治县","新宾满族自治县","其他"]},

        {"name":"本溪", "area":["平山区","明山区","溪湖区","南芬区","本溪满族自治县","桓仁满族自治县","其他"]},

        {"name":"丹东", "area":["振兴区","元宝区","振安区","东港市","凤城市","宽甸满族自治县","其他"]},

        {"name":"锦州", "area":["太和区","古塔区","凌河区","凌海市","黑山县","义县","北宁市","其他"]},

        {"name":"营口", "area":["站前区","西市区","鲅鱼圈区","老边区","大石桥市","盖州市","其他"]},

        {"name":"阜新", "area":["海州区","新邱区","太平区","清河门区","细河区","彰武县","阜新蒙古族自治县","其他"]},

        {"name":"辽阳", "area":["白塔区","文圣区","宏伟区","太子河区","弓长岭区","灯塔市","辽阳县","其他"]},

        {"name":"盘锦", "area":["双台子区","兴隆台区","盘山县","大洼县","其他"]},

        {"name":"铁岭", "area":["银州区","清河区","调兵山市","开原市","铁岭县","昌图县","西丰县","其他"]},

        {"name":"朝阳", "area":["双塔区","龙城区","凌源市","北票市","朝阳县","建平县","喀喇沁左翼蒙古族自治县","其他"]},

        {"name":"葫芦岛", "area":["龙港区","南票区","连山区","兴城市","绥中县","建昌县","其他"]},

        {"name":"其他", "area":["其他"]}

    ]},

    { "name": "吉林", "city":[

        {"name":"长春", "area":["朝阳区","宽城区","二道区","南关区","绿园区","双阳区","九台市","榆树市","德惠市","农安县","其他"]},

        {"name":"吉林", "area":["船营区","昌邑区","龙潭区","丰满区","舒兰市","桦甸市","蛟河市","磐石市","永吉县","其他"]},

        {"name":"四平", "area":["铁西区","铁东区","公主岭市","双辽市","梨树县","伊通满族自治县","其他"]},

        {"name":"辽源", "area":["龙山区","西安区","东辽县","东丰县","其他"]},

        {"name":"通化", "area":["东昌区","二道江区","梅河口市","集安市","通化县","辉南县","柳河县","其他"]},

        {"name":"白山", "area":["八道江区","江源区","临江市","靖宇县","抚松县","长白朝鲜族自治县","其他"]},

        {"name":"松原", "area":["宁江区","乾安县","长岭县","扶余县","前郭尔罗斯蒙古族自治县","其他"]},

        {"name":"白城", "area":["洮北区","大安市","洮南市","镇赉县","通榆县","其他"]},

        {"name":"延边朝鲜族自治州", "area":["延吉市","图们市","敦化市","龙井市","珲春市","和龙市","安图县","汪清县","其他"]},

        {"name":"其他", "area":["其他"]}

    ]},

    { "name": "黑龙江", "city":[

        {"name":"哈尔滨", "area":["松北区","道里区","南岗区","平房区","香坊区","道外区","呼兰区","阿城区","双城市","尚志市","五常市","宾县","方正县","通河县","巴彦县","延寿县","木兰县","依兰县","其他"]},

        {"name":"齐齐哈尔", "area":["龙沙区","昂昂溪区","铁锋区","建华区","富拉尔基区","碾子山区","梅里斯达斡尔族区","讷河市","富裕县","拜泉县","甘南县","依安县","克山县","泰来县","克东县","龙江县","其他"]},

        {"name":"鹤岗", "area":["兴山区","工农区","南山区","兴安区","向阳区","东山区","萝北县","绥滨县","其他"]},

        {"name":"双鸭山", "area":["尖山区","岭东区","四方台区","宝山区","集贤县","宝清县","友谊县","饶河县","其他"]},

        {"name":"鸡西", "area":["鸡冠区","恒山区","城子河区","滴道区","梨树区","麻山区","密山市","虎林市","鸡东县","其他"]},

        {"name":"大庆", "area":["萨尔图区","红岗区","龙凤区","让胡路区","大同区","林甸县","肇州县","肇源县","杜尔伯特蒙古族自治县","其他"]},

        {"name":"伊春", "area":["伊春区","带岭区","南岔区","金山屯区","西林区","美溪区","乌马河区","翠峦区","友好区","上甘岭区","五营区","红星区","新青区","汤旺河区","乌伊岭区","铁力市","嘉荫县","其他"]},

        {"name":"牡丹江", "area":["爱民区","东安区","阳明区","西安区","绥芬河市","宁安市","海林市","穆棱市","林口县","东宁县","其他"]},

        {"name":"佳木斯", "area":["向阳区","前进区","东风区","郊区","同江市","富锦市","桦川县","抚远县","桦南县","汤原县","其他"]},

        {"name":"七台河", "area":["桃山区","新兴区","茄子河区","勃利县","其他"]},

        {"name":"黑河", "area":["爱辉区","北安市","五大连池市","逊克县","嫩江县","孙吴县","其他"]},

        {"name":"绥化", "area":["北林区","安达市","肇东市","海伦市","绥棱县","兰西县","明水县","青冈县","庆安县","望奎县","其他"]},

        {"name":"大兴安岭地区", "area":["呼玛县","塔河县","漠河县","大兴安岭辖区","其他"]},

        {"name":"其他", "area":["其他"]}

    ]},

    { "name": "上海", "city":[

        {"name":"上海", "area":["黄浦区","卢湾区","徐汇区","长宁区","静安区","普陀区","闸北区","虹口区","杨浦区","宝山区","闵行区","嘉定区","松江区","金山区","青浦区","南汇区","奉贤区","浦东新区","崇明县","其他"]}

    ]},

    { "name": "江苏", "city":[

        {"name":"南京", "area":["玄武区","白下区","秦淮区","建邺区","鼓楼区","下关区","栖霞区","雨花台区","浦口区","江宁区","六合区","溧水县","高淳县","其他"]},

        {"name":"苏州", "area":["金阊区","平江区","沧浪区","虎丘区","吴中区","相城区","常熟市","张家港市","昆山市","吴江市","太仓市","其他"]},

        {"name":"无锡", "area":["崇安区","南长区","北塘区","滨湖区","锡山区","惠山区","江阴市","宜兴市","其他"]},

        {"name":"常州", "area":["钟楼区","天宁区","戚墅堰区","新北区","武进区","金坛市","溧阳市","其他"]},

        {"name":"镇江", "area":["京口区","润州区","丹徒区","丹阳市","扬中市","句容市","其他"]},

        {"name":"南通", "area":["崇川区","港闸区","通州市","如皋市","海门市","启东市","海安县","如东县","其他"]},

        {"name":"泰州", "area":["海陵区","高港区","姜堰市","泰兴市","靖江市","兴化市","其他"]},

        {"name":"扬州", "area":["广陵区","维扬区","邗江区","江都市","仪征市","高邮市","宝应县","其他"]},

        {"name":"盐城", "area":["亭湖区","盐都区","大丰市","东台市","建湖县","射阳县","阜宁县","滨海县","响水县","其他"]},

        {"name":"连云港", "area":["新浦区","海州区","连云区","东海县","灌云县","赣榆县","灌南县","其他"]},

        {"name":"徐州", "area":["云龙区","鼓楼区","九里区","泉山区","贾汪区","邳州市","新沂市","铜山县","睢宁县","沛县","丰县","其他"]},

        {"name":"淮安", "area":["清河区","清浦区","楚州区","淮阴区","涟水县","洪泽县","金湖县","盱眙县","其他"]},

        {"name":"宿迁", "area":["宿城区","宿豫区","沭阳县","泗阳县","泗洪县","其他"]},

        {"name":"其他", "area":["其他"]}

    ]},

    { "name": "浙江", "city":[

        {"name":"杭州", "area":["拱墅区","西湖区","上城区","下城区","江干区","滨江区","余杭区","萧山区","建德市","富阳市","临安市","桐庐县","淳安县","其他"]},

        {"name":"宁波", "area":["海曙区","江东区","江北区","镇海区","北仑区","鄞州区","余姚市","慈溪市","奉化市","宁海县","象山县","其他"]},

        {"name":"温州", "area":["鹿城区","龙湾区","瓯海区","瑞安市","乐清市","永嘉县","洞头县","平阳县","苍南县","文成县","泰顺县","其他"]},

        {"name":"嘉兴", "area":["秀城区","秀洲区","海宁市","平湖市","桐乡市","嘉善县","海盐县","其他"]},

        {"name":"湖州", "area":["吴兴区","南浔区","长兴县","德清县","安吉县","其他"]},

        {"name":"绍兴", "area":["越城区","诸暨市","上虞市","嵊州市","绍兴县","新昌县","其他"]},

        {"name":"金华", "area":["婺城区","金东区","兰溪市","义乌市","东阳市","永康市","武义县","浦江县","磐安县","其他"]},

        {"name":"衢州", "area":["柯城区","衢江区","江山市","龙游县","常山县","开化县","其他"]},

        {"name":"舟山", "area":["定海区","普陀区","岱山县","嵊泗县","其他"]},

        {"name":"台州", "area":["椒江区","黄岩区","路桥区","临海市","温岭市","玉环县","天台县","仙居县","三门县","其他"]},

        {"name":"丽水", "area":["莲都区","龙泉市","缙云县","青田县","云和县","遂昌县","松阳县","庆元县","景宁畲族自治县","其他"]},

        {"name":"其他", "area":["其他"]}

    ]},

    { "name": "安徽", "city":[

        {"name":"合肥", "area":["庐阳区","瑶海区","蜀山区","包河区","长丰县","肥东县","肥西县","其他"]},

        {"name":"芜湖", "area":["镜湖区","弋江区","鸠江区","三山区","芜湖县","南陵县","繁昌县","其他"]},

        {"name":"蚌埠", "area":["蚌山区","龙子湖区","禹会区","淮上区","怀远县","固镇县","五河县","其他"]},

        {"name":"淮南", "area":["田家庵区","大通区","谢家集区","八公山区","潘集区","凤台县","其他"]},

        {"name":"马鞍山", "area":["雨山区","花山区","金家庄区","当涂县","其他"]},

        {"name":"淮北", "area":["相山区","杜集区","烈山区","濉溪县","其他"]},

        {"name":"铜陵", "area":["铜官山区","狮子山区","郊区","铜陵县","其他"]},

        {"name":"安庆", "area":["迎江区","大观区","宜秀区","桐城市","宿松县","枞阳县","太湖县","怀宁县","岳西县","望江县","潜山县","其他"]},

        {"name":"黄山", "area":["屯溪区","黄山区","徽州区","休宁县","歙县","祁门县","黟县","其他"]},

        {"name":"滁州", "area":["琅琊区","南谯区","天长市","明光市","全椒县","来安县","定远县","凤阳县","其他"]},

        {"name":"阜阳", "area":["颍州区","颍东区","颍泉区","界首市","临泉县","颍上县","阜南县","太和县","其他"]},

        {"name":"宿州", "area":["埇桥区","萧县","泗县","砀山县","灵璧县","其他"]},

        {"name":"巢湖", "area":["居巢区","含山县","无为县","庐江县","和县","其他"]},

        {"name":"六安", "area":["金安区","裕安区","寿县","霍山县","霍邱县","舒城县","金寨县","其他"]},

        {"name":"亳州", "area":["谯城区","利辛县","涡阳县","蒙城县","其他"]},

        {"name":"池州", "area":["贵池区","东至县","石台县","青阳县","其他"]},

        {"name":"宣城", "area":["宣州区","宁国市","广德县","郎溪县","泾县","旌德县","绩溪县","其他"]},

        {"name":"其他", "area":["其他"]}

    ]},

    { "name": "福建", "city":[

        {"name":"福州", "area":["鼓楼区","台江区","仓山区","马尾区","晋安区","福清市","长乐市","闽侯县","闽清县","永泰县","连江县","罗源县","平潭县","其他"]},

        {"name":"厦门", "area":["思明区","海沧区","湖里区","集美区","同安区","翔安区","其他"]},

        {"name":"莆田", "area":["城厢区","涵江区","荔城区","秀屿区","仙游县","其他"]},

        {"name":"三明", "area":["梅列区","三元区","永安市","明溪县","将乐县","大田县","宁化县","建宁县","沙县","尤溪县","清流县","泰宁县","其他"]},

        {"name":"泉州", "area":["鲤城区","丰泽区","洛江区","泉港区","石狮市","晋江市","南安市","惠安县","永春县","安溪县","德化县","金门县","其他"]},

        {"name":"漳州", "area":["芗城区","龙文区","龙海市","平和县","南靖县","诏安县","漳浦县","华安县","东山县","长泰县","云霄县","其他"]},

        {"name":"南平", "area":["延平区","建瓯市","邵武市","武夷山市","建阳市","松溪县","光泽县","顺昌县","浦城县","政和县","其他"]},

        {"name":"龙岩", "area":["新罗区","漳平市","长汀县","武平县","上杭县","永定县","连城县","其他"]},

        {"name":"宁德", "area":["蕉城区","福安市","福鼎市","寿宁县","霞浦县","柘荣县","屏南县","古田县","周宁县","其他"]},

        {"name":"其他", "area":["其他"]}

    ]},

    { "name": "江西", "city":[

        {"name":"南昌", "area":["东湖区","西湖区","青云谱区","湾里区","青山湖区","新建县","南昌县","进贤县","安义县","其他"]},

        {"name":"景德镇", "area":["珠山区","昌江区","乐平市","浮梁县","其他"]},

        {"name":"萍乡", "area":["安源区","湘东区","莲花县","上栗县","芦溪县","其他"]},

        {"name":"九江", "area":["浔阳区","庐山区","瑞昌市","九江县","星子县","武宁县","彭泽县","永修县","修水县","湖口县","德安县","都昌县","其他"]},

        {"name":"新余", "area":["渝水区","分宜县","其他"]},

        {"name":"鹰潭", "area":["月湖区","贵溪市","余江县","其他"]},

        {"name":"赣州", "area":["章贡区","瑞金市","南康市","石城县","安远县","赣县","宁都县","寻乌县","兴国县","定南县","上犹县","于都县","龙南县","崇义县","信丰县","全南县","大余县","会昌县","其他"]},

        {"name":"吉安", "area":["吉州区","青原区","井冈山市","吉安县","永丰县","永新县","新干县","泰和县","峡江县","遂川县","安福县","吉水县","万安县","其他"]},

        {"name":"宜春", "area":["袁州区","丰城市","樟树市","高安市","铜鼓县","靖安县","宜丰县","奉新县","万载县","上高县","其他"]},

        {"name":"抚州", "area":["临川区","南丰县","乐安县","金溪县","南城县","东乡县","资溪县","宜黄县","广昌县","黎川县","崇仁县","其他"]},

        {"name":"上饶", "area":["信州区","德兴市","上饶县","广丰县","鄱阳县","婺源县","铅山县","余干县","横峰县","弋阳县","玉山县","万年县","其他"]},

        {"name":"其他", "area":["其他"]}

    ]},

    { "name": "山东", "city":[

        {"name":"济南", "area":["市中区","历下区","天桥区","槐荫区","历城区","长清区","章丘市","平阴县","济阳县","商河县","其他"]},

        {"name":"青岛", "area":["市南区","市北区","城阳区","四方区","李沧区","黄岛区","崂山区","胶南市","胶州市","平度市","莱西市","即墨市","其他"]},

        {"name":"淄博", "area":["张店区","临淄区","淄川区","博山区","周村区","桓台县","高青县","沂源县","其他"]},

        {"name":"枣庄", "area":["市中区","山亭区","峄城区","台儿庄区","薛城区","滕州市","其他"]},

        {"name":"东营", "area":["东营区","河口区","垦利县","广饶县","利津县","其他"]},

        {"name":"烟台", "area":["芝罘区","福山区","牟平区","莱山区","龙口市","莱阳市","莱州市","招远市","蓬莱市","栖霞市","海阳市","长岛县","其他"]},

        {"name":"潍坊", "area":["潍城区","寒亭区","坊子区","奎文区","青州市","诸城市","寿光市","安丘市","高密市","昌邑市","昌乐县","临朐县","其他"]},

        {"name":"济宁", "area":["市中区","任城区","曲阜市","兖州市","邹城市","鱼台县","金乡县","嘉祥县","微山县","汶上县","泗水县","梁山县","其他"]},

        {"name":"泰安", "area":["泰山区","岱岳区","新泰市","肥城市","宁阳县","东平县","其他"]},

        {"name":"威海", "area":["环翠区","乳山市","文登市","荣成市","其他"]},

        {"name":"日照", "area":["东港区","岚山区","五莲县","莒县","其他"]},

        {"name":"莱芜", "area":["莱城区","钢城区","其他"]},

        {"name":"临沂", "area":["兰山区","罗庄区","河东区","沂南县","郯城县","沂水县","苍山县","费县","平邑县","莒南县","蒙阴县","临沭县","其他"]},

        {"name":"德州", "area":["德城区","乐陵市","禹城市","陵县","宁津县","齐河县","武城县","庆云县","平原县","夏津县","临邑县","其他"]},

        {"name":"聊城", "area":["东昌府区","临清市","高唐县","阳谷县","茌平县","莘县","东阿县","冠县","其他"]},

        {"name":"滨州", "area":["滨城区","邹平县","沾化县","惠民县","博兴县","阳信县","无棣县","其他"]},

        {"name":"菏泽", "area":["牡丹区","鄄城县","单县","郓城县","曹县","定陶县","巨野县","东明县","成武县","其他"]},

        {"name":"其他", "area":["其他"]}

    ]},

    { "name": "河南", "city":[

        {"name":"郑州", "area":["中原区","金水区","二七区","管城回族区","上街区","惠济区","巩义市","新郑市","新密市","登封市","荥阳市","中牟县","其他"]},

        {"name":"开封", "area":["鼓楼区","龙亭区","顺河回族区","禹王台区","金明区","开封县","尉氏县","兰考县","杞县","通许县","其他"]},

        {"name":"洛阳", "area":["西工区","老城区","涧西区","瀍河回族区","洛龙区","吉利区","偃师市","孟津县","汝阳县","伊川县","洛宁县","嵩县","宜阳县","新安县","栾川县","其他"]},

        {"name":"平顶山", "area":["新华区","卫东区","湛河区","石龙区","汝州市","舞钢市","宝丰县","叶县","郏县","鲁山县","其他"]},

        {"name":"安阳", "area":["北关区","文峰区","殷都区","龙安区","林州市","安阳县","滑县","内黄县","汤阴县","其他"]},

        {"name":"鹤壁", "area":["淇滨区","山城区","鹤山区","浚县","淇县","其他"]},

        {"name":"新乡", "area":["卫滨区","红旗区","凤泉区","牧野区","卫辉市","辉县市","新乡县","获嘉县","原阳县","长垣县","封丘县","延津县","其他"]},

        {"name":"焦作", "area":["解放区","中站区","马村区","山阳区","沁阳市","孟州市","修武县","温县","武陟县","博爱县","其他"]},

        {"name":"濮阳", "area":["华龙区","濮阳县","南乐县","台前县","清丰县","范县","其他"]},

        {"name":"许昌", "area":["魏都区","禹州市","长葛市","许昌县","鄢陵县","襄城县","其他"]},

        {"name":"漯河", "area":["源汇区","郾城区","召陵区","临颍县","舞阳县","其他"]},

        {"name":"三门峡", "area":["湖滨区","义马市","灵宝市","渑池县","卢氏县","陕县","其他"]},

        {"name":"南阳", "area":["卧龙区","宛城区","邓州市","桐柏县","方城县","淅川县","镇平县","唐河县","南召县","内乡县","新野县","社旗县","西峡县","其他"]},

        {"name":"商丘", "area":["梁园区","睢阳区","永城市","宁陵县","虞城县","民权县","夏邑县","柘城县","睢县","其他"]},

        {"name":"信阳", "area":["浉河区","平桥区","潢川县","淮滨县","息县","新县","商城县","固始县","罗山县","光山县","其他"]},

        {"name":"周口", "area":["川汇区","项城市","商水县","淮阳县","太康县","鹿邑县","西华县","扶沟县","沈丘县","郸城县","其他"]},

        {"name":"驻马店", "area":["驿城区","确山县","新蔡县","上蔡县","西平县","泌阳县","平舆县","汝南县","遂平县","正阳县","其他"]},

        {"name":"焦作", "area":["济源市","其他"]},

        {"name":"其他", "area":["其他"]}

    ]},

    { "name": "湖北", "city":[

        {"name":"武汉", "area":["江岸区","武昌区","江汉区","硚口区","汉阳区","青山区","洪山区","东西湖区","汉南区","蔡甸区","江夏区","黄陂区","新洲区","其他"]},

        {"name":"黄石", "area":["黄石港区","西塞山区","下陆区","铁山区","大冶市","阳新县","其他"]},

        {"name":"十堰", "area":["张湾区","茅箭区","丹江口市","郧县","竹山县","房县","郧西县","竹溪县","其他"]},

        {"name":"荆州", "area":["沙市区","荆州区","洪湖市","石首市","松滋市","监利县","公安县","江陵县","其他"]},

        {"name":"宜昌", "area":["西陵区","伍家岗区","点军区","猇亭区","夷陵区","宜都市","当阳市","枝江市","秭归县","远安县","兴山县","五峰土家族自治县","长阳土家族自治县","其他"]},

        {"name":"襄樊", "area":["襄城区","樊城区","襄阳区","老河口市","枣阳市","宜城市","南漳县","谷城县","保康县","其他"]},

        {"name":"鄂州", "area":["鄂城区","华容区","梁子湖区","其他"]},

        {"name":"荆门", "area":["东宝区","掇刀区","钟祥市","京山县","沙洋县","其他"]},

        {"name":"孝感", "area":["孝南区","应城市","安陆市","汉川市","云梦县","大悟县","孝昌县","其他"]},

        {"name":"黄冈", "area":["黄州区","麻城市","武穴市","红安县","罗田县","浠水县","蕲春县","黄梅县","英山县","团风县","其他"]},

        {"name":"咸宁", "area":["咸安区","赤壁市","嘉鱼县","通山县","崇阳县","通城县","其他"]},

        {"name":"随州", "area":["曾都区","广水市","其他"]},

        {"name":"恩施土家族苗族自治州", "area":["恩施市","利川市","建始县","来凤县","巴东县","鹤峰县","宣恩县","咸丰县","其他"]},

        {"name":"仙桃", "area":["仙桃"]},

        {"name":"天门", "area":["天门"]},

        {"name":"潜江", "area":["潜江"]},

        {"name":"神农架林区", "area":["神农架林区"]},

        {"name":"其他", "area":["其他"]}

    ]},

    { "name": "湖南", "city":[

        {"name":"长沙", "area":["岳麓区","芙蓉区","天心区","开福区","雨花区","浏阳市","长沙县","望城县","宁乡县","其他"]},

        {"name":"株洲", "area":["天元区","荷塘区","芦淞区","石峰区","醴陵市","株洲县","炎陵县","茶陵县","攸县","其他"]},

        {"name":"湘潭", "area":["岳塘区","雨湖区","湘乡市","韶山市","湘潭县","其他"]},

        {"name":"衡阳", "area":["雁峰区","珠晖区","石鼓区","蒸湘区","南岳区","耒阳市","常宁市","衡阳县","衡东县","衡山县","衡南县","祁东县","其他"]},

        {"name":"邵阳", "area":["双清区","大祥区","北塔区","武冈市","邵东县","洞口县","新邵县","绥宁县","新宁县","邵阳县","隆回县","城步苗族自治县","其他"]},

        {"name":"岳阳", "area":["岳阳楼区","云溪区","君山区","临湘市","汨罗市","岳阳县","湘阴县","平江县","华容县","其他"]},

        {"name":"常德", "area":["武陵区","鼎城区","津市市","澧县","临澧县","桃源县","汉寿县","安乡县","石门县","其他"]},

        {"name":"张家界", "area":["永定区","武陵源区","慈利县","桑植县","其他"]},

        {"name":"益阳", "area":["赫山区","资阳区","沅江市","桃江县","南县","安化县","其他"]},

        {"name":"郴州", "area":["北湖区","苏仙区","资兴市","宜章县","汝城县","安仁县","嘉禾县","临武县","桂东县","永兴县","桂阳县","其他"]},

        {"name":"永州", "area":["冷水滩区","零陵区","祁阳县","蓝山县","宁远县","新田县","东安县","江永县","道县","双牌县","江华瑶族自治县","其他"]},

        {"name":"怀化", "area":["鹤城区","洪江市","会同县","沅陵县","辰溪县","溆浦县","中方县","新晃侗族自治县","芷江侗族自治县","通道侗族自治县","靖州苗族侗族自治县","麻阳苗族自治县","其他"]},

        {"name":"娄底", "area":["娄星区","冷水江市","涟源市","新化县","双峰县","其他"]},

        {"name":"湘西土家族苗族自治州", "area":["吉首市","古丈县","龙山县","永顺县","凤凰县","泸溪县","保靖县","花垣县","其他"]},

        {"name":"其他", "area":["其他"]}

    ]},

    { "name": "广东", "city":[

        {"name":"广州", "area":["越秀区","荔湾区","海珠区","天河区","白云区","黄埔区","番禺区","花都区","南沙区","萝岗区","增城市","从化市","其他"]},

        {"name":"深圳", "area":["福田区","罗湖区","南山区","宝安区","龙岗区","盐田区","其他"]},

        {"name":"东莞", "area":["莞城","常平","塘厦","塘厦","塘厦","其他"]},

        {"name":"中山", "area":["中山"]},

        {"name":"潮州", "area":["湘桥区","潮安县","饶平县","其他"]},

        {"name":"揭阳", "area":["榕城区","揭东县","揭西县","惠来县","普宁市","其他"]},

        {"name":"云浮", "area":["云城区","新兴县","郁南县","云安县","罗定市","其他"]},

        {"name":"珠海", "area":["香洲区","斗门区","金湾区","其他"]},

        {"name":"汕头", "area":["金平区","濠江区","龙湖区","潮阳区","潮南区","澄海区","南澳县","其他"]},

        {"name":"韶关", "area":["浈江区","武江区","曲江区","乐昌市","南雄市","始兴县","仁化县","翁源县","新丰县","乳源瑶族自治县","其他"]},

        {"name":"佛山", "area":["禅城区","南海区","顺德区","三水区","高明区","其他"]},

        {"name":"江门", "area":["蓬江区","江海区","新会区","恩平市","台山市","开平市","鹤山市","其他"]},

        {"name":"湛江", "area":["赤坎区","霞山区","坡头区","麻章区","吴川市","廉江市","雷州市","遂溪县","徐闻县","其他"]},

        {"name":"茂名", "area":["茂南区","茂港区","化州市","信宜市","高州市","电白县","其他"]},

        {"name":"肇庆", "area":["端州区","鼎湖区","高要市","四会市","广宁县","怀集县","封开县","德庆县","其他"]},

        {"name":"惠州", "area":["惠城区","惠阳区","博罗县","惠东县","龙门县","其他"]},

        {"name":"梅州", "area":["梅江区","兴宁市","梅县","大埔县","丰顺县","五华县","平远县","蕉岭县","其他"]},

        {"name":"汕尾", "area":["城区","陆丰市","海丰县","陆河县","其他"]},

        {"name":"河源", "area":["源城区","紫金县","龙川县","连平县","和平县","东源县","其他"]},

        {"name":"阳江", "area":["江城区","阳春市","阳西县","阳东县","其他"]},

        {"name":"清远", "area":["清城区","英德市","连州市","佛冈县","阳山县","清新县","连山壮族瑶族自治县","连南瑶族自治县","其他"]}

    ]},

    { "name": "广西", "city":[

        {"name":"南宁", "area":["青秀区","兴宁区","西乡塘区","良庆区","江南区","邕宁区","武鸣县","隆安县","马山县","上林县","宾阳县","横县","其他"]},

        {"name":"柳州", "area":["城中区","鱼峰区","柳北区","柳南区","柳江县","柳城县","鹿寨县","融安县","融水苗族自治县","三江侗族自治县","其他"]},

        {"name":"桂林", "area":["象山区","秀峰区","叠彩区","七星区","雁山区","阳朔县","临桂县","灵川县","全州县","平乐县","兴安县","灌阳县","荔浦县","资源县","永福县","龙胜各族自治县","恭城瑶族自治县","其他"]},

        {"name":"梧州", "area":["万秀区","蝶山区","长洲区","岑溪市","苍梧县","藤县","蒙山县","其他"]},

        {"name":"北海", "area":["海城区","银海区","铁山港区","合浦县","其他"]},

        {"name":"防城港", "area":["港口区","防城区","东兴市","上思县","其他"]},

        {"name":"钦州", "area":["钦南区","钦北区","灵山县","浦北县","其他"]},

        {"name":"贵港", "area":["港北区","港南区","覃塘区","桂平市","平南县","其他"]},

        {"name":"玉林", "area":["玉州区","北流市","容县","陆川县","博白县","兴业县","其他"]},

        {"name":"百色", "area":["右江区","凌云县","平果县","西林县","乐业县","德保县","田林县","田阳县","靖西县","田东县","那坡县","隆林各族自治县","其他"]},

        {"name":"贺州", "area":["八步区","钟山县","昭平县","富川瑶族自治县","其他"]},

        {"name":"河池", "area":["金城江区","宜州市","天峨县","凤山县","南丹县","东兰县","都安瑶族自治县","罗城仫佬族自治县","巴马瑶族自治县","环江毛南族自治县","大化瑶族自治县","其他"]},

        {"name":"来宾", "area":["兴宾区","合山市","象州县","武宣县","忻城县","金秀瑶族自治县","其他"]},

        {"name":"崇左", "area":["江州区","凭祥市","宁明县","扶绥县","龙州县","大新县","天等县","其他"]},

        {"name":"其他", "area":["其他"]}

    ]},

    { "name": "海南", "city":[

        {"name":"海口", "area":["龙华区","秀英区","琼山区","美兰区","其他"]},

        {"name":"三亚", "area":["三亚市","其他"]},

        {"name":"五指山", "area":["五指山"]},

        {"name":"琼海", "area":["琼海"]},

        {"name":"儋州", "area":["儋州"]},

        {"name":"文昌", "area":["文昌"]},

        {"name":"万宁", "area":["万宁"]},

        {"name":"东方", "area":["东方"]},

        {"name":"澄迈县", "area":["澄迈县"]},

        {"name":"定安县", "area":["定安县"]},

        {"name":"屯昌县", "area":["屯昌县"]},

        {"name":"临高县", "area":["临高县"]},

        {"name":"白沙黎族自治县", "area":["白沙黎族自治县"]},

        {"name":"昌江黎族自治县", "area":["昌江黎族自治县"]},

        {"name":"乐东黎族自治县", "area":["乐东黎族自治县"]},

        {"name":"陵水黎族自治县", "area":["陵水黎族自治县"]},

        {"name":"保亭黎族苗族自治县", "area":["保亭黎族苗族自治县"]},

        {"name":"琼中黎族苗族自治县", "area":["琼中黎族苗族自治县"]},

        {"name":"其他", "area":["其他"]}

    ]},

    { "name": "重庆", "city":[

        {"name":"重庆", "area":["渝中区","大渡口区","江北区","南岸区","北碚区","渝北区","巴南区","长寿区","双桥区","沙坪坝区","万盛区","万州区","涪陵区","黔江区","永川区","合川区","江津区","九龙坡区","南川区","綦江县","潼南县","荣昌县","璧山县","大足县","铜梁县","梁平县","开县","忠县","城口县","垫江县","武隆县","丰都县","奉节县","云阳县","巫溪县","巫山县","石柱土家族自治县","秀山土家族苗族自治县","酉阳土家族苗族自治县","彭水苗族土家族自治县","其他"]}

    ]},

    { "name": "四川", "city":[

        {"name":"成都", "area":["青羊区","锦江区","金牛区","武侯区","成华区","龙泉驿区","青白江区","新都区","温江区","都江堰市","彭州市","邛崃市","崇州市","金堂县","郫县","新津县","双流县","蒲江县","大邑县","其他"]},

        {"name":"自贡", "area":["大安区","自流井区","贡井区","沿滩区","荣县","富顺县","其他"]},

        {"name":"攀枝花", "area":["仁和区","米易县","盐边县","东区","西区","其他"]},

        {"name":"泸州", "area":["江阳区","纳溪区","龙马潭区","泸县","合江县","叙永县","古蔺县","其他"]},

        {"name":"德阳", "area":["旌阳区","广汉市","什邡市","绵竹市","罗江县","中江县","其他"]},

        {"name":"绵阳", "area":["涪城区","游仙区","江油市","盐亭县","三台县","平武县","安县","梓潼县","北川羌族自治县","其他"]},

        {"name":"广元", "area":["元坝区","朝天区","青川县","旺苍县","剑阁县","苍溪县","市中区","其他"]},

        {"name":"遂宁", "area":["船山区","安居区","射洪县","蓬溪县","大英县","其他"]},

        {"name":"内江", "area":["市中区","东兴区","资中县","隆昌县","威远县","其他"]},

        {"name":"乐山", "area":["市中区","五通桥区","沙湾区","金口河区","峨眉山市","夹江县","井研县","犍为县","沐川县","马边彝族自治县","峨边彝族自治县","其他"]},

        {"name":"南充", "area":["顺庆区","高坪区","嘉陵区","阆中市","营山县","蓬安县","仪陇县","南部县","西充县","其他"]},

        {"name":"眉山", "area":["东坡区","仁寿县","彭山县","洪雅县","丹棱县","青神县","其他"]},

        {"name":"宜宾", "area":["翠屏区","宜宾县","兴文县","南溪县","珙县","长宁县","高县","江安县","筠连县","屏山县","其他"]},

        {"name":"广安", "area":["广安区","华蓥市","岳池县","邻水县","武胜县","其他"]},

        {"name":"达州", "area":["通川区","万源市","达县","渠县","宣汉县","开江县","大竹县","其他"]},

        {"name":"雅安", "area":["雨城区","芦山县","石棉县","名山县","天全县","荥经县","宝兴县","汉源县","其他"]},

        {"name":"巴中", "area":["巴州区","南江县","平昌县","通江县","其他"]},

        {"name":"资阳", "area":["雁江区","简阳市","安岳县","乐至县","其他"]},

        {"name":"阿坝藏族羌族自治州", "area":["马尔康县","九寨沟县","红原县","汶川县","阿坝县","理县","若尔盖县","小金县","黑水县","金川县","松潘县","壤塘县","茂县","其他"]},

        {"name":"甘孜藏族自治州", "area":["康定县","丹巴县","炉霍县","九龙县","甘孜县","雅江县","新龙县","道孚县","白玉县","理塘县","德格县","乡城县","石渠县","稻城县","色达县","巴塘县","泸定县","得荣县","其他"]},

        {"name":"凉山彝族自治州", "area":["西昌市","美姑县","昭觉县","金阳县","甘洛县","布拖县","雷波县","普格县","宁南县","喜德县","会东县","越西县","会理县","盐源县","德昌县","冕宁县","木里藏族自治县","其他"]},

        {"name":"其他", "area":["其他"]}

    ]},

    { "name": "贵州", "city":[

        {"name":"贵阳", "area":["南明区","云岩区","花溪区","乌当区","白云区","小河区","清镇市","开阳县","修文县","息烽县","其他"]},

        {"name":"六盘水", "area":["钟山区","水城县","盘县","六枝特区","其他"]},

        {"name":"遵义", "area":["红花岗区","汇川区","赤水市","仁怀市","遵义县","绥阳县","桐梓县","习水县","凤冈县","正安县","余庆县","湄潭县","道真仡佬族苗族自治县","务川仡佬族苗族自治县","其他"]},

        {"name":"安顺", "area":["西秀区","普定县","平坝县","镇宁布依族苗族自治县","紫云苗族布依族自治县","关岭布依族苗族自治县","其他"]},

        {"name":"铜仁地区", "area":["铜仁市","德江县","江口县","思南县","石阡县","玉屏侗族自治县","松桃苗族自治县","印江土家族苗族自治县","沿河土家族自治县","万山特区","其他"]},

        {"name":"毕节地区", "area":["毕节市","黔西县","大方县","织金县","金沙县","赫章县","纳雍县","威宁彝族回族苗族自治县","其他"]},

        {"name":"黔西南布依族苗族自治州", "area":["兴义市","望谟县","兴仁县","普安县","册亨县","晴隆县","贞丰县","安龙县","其他"]},

        {"name":"黔东南苗族侗族自治州", "area":["凯里市","施秉县","从江县","锦屏县","镇远县","麻江县","台江县","天柱县","黄平县","榕江县","剑河县","三穗县","雷山县","黎平县","岑巩县","丹寨县","其他"]},

        {"name":"黔南布依族苗族自治州", "area":["都匀市","福泉市","贵定县","惠水县","罗甸县","瓮安县","荔波县","龙里县","平塘县","长顺县","独山县","三都水族自治县","其他"]},

        {"name":"其他", "area":["其他"]}

    ]},

    { "name": "云南", "city":[

        {"name":"昆明", "area":["盘龙区","五华区","官渡区","西山区","东川区","安宁市","呈贡县","晋宁县","富民县","宜良县","嵩明县","石林彝族自治县","禄劝彝族苗族自治县","寻甸回族彝族自治县","其他"]},

        {"name":"曲靖", "area":["麒麟区","宣威市","马龙县","沾益县","富源县","罗平县","师宗县","陆良县","会泽县","其他"]},

        {"name":"玉溪", "area":["红塔区","江川县","澄江县","通海县","华宁县","易门县","峨山彝族自治县","新平彝族傣族自治县","元江哈尼族彝族傣族自治县","其他"]},

        {"name":"保山", "area":["隆阳区","施甸县","腾冲县","龙陵县","昌宁县","其他"]},

        {"name":"昭通", "area":["昭阳区","鲁甸县","巧家县","盐津县","大关县","永善县","绥江县","镇雄县","彝良县","威信县","水富县","其他"]},

        {"name":"丽江", "area":["古城区","永胜县","华坪县","玉龙纳西族自治县","宁蒗彝族自治县","其他"]},

        {"name":"普洱", "area":["思茅区","普洱哈尼族彝族自治县","墨江哈尼族自治县","景东彝族自治县","景谷傣族彝族自治县","镇沅彝族哈尼族拉祜族自治县","江城哈尼族彝族自治县","孟连傣族拉祜族佤族自治县","澜沧拉祜族自治县","西盟佤族自治县","其他"]},

        {"name":"临沧", "area":["临翔区","凤庆县","云县","永德县","镇康县","双江拉祜族佤族布朗族傣族自治县","耿马傣族佤族自治县","沧源佤族自治县","其他"]},

        {"name":"德宏傣族景颇族自治州", "area":["潞西市","瑞丽市","梁河县","盈江县","陇川县","其他"]},

        {"name":"怒江傈僳族自治州", "area":["泸水县","福贡县","贡山独龙族怒族自治县","兰坪白族普米族自治县","其他"]},

        {"name":"迪庆藏族自治州", "area":["香格里拉县","德钦县","维西傈僳族自治县","其他"]},

        {"name":"大理白族自治州", "area":["大理市","祥云县","宾川县","弥渡县","永平县","云龙县","洱源县","剑川县","鹤庆县","漾濞彝族自治县","南涧彝族自治县","巍山彝族回族自治县","其他"]},

        {"name":"楚雄彝族自治州", "area":["楚雄市","双柏县","牟定县","南华县","姚安县","大姚县","永仁县","元谋县","武定县","禄丰县","其他"]},

        {"name":"红河哈尼族彝族自治州", "area":["蒙自县","个旧市","开远市","绿春县","建水县","石屏县","弥勒县","泸西县","元阳县","红河县","金平苗族瑶族傣族自治县","河口瑶族自治县","屏边苗族自治县","其他"]},

        {"name":"文山壮族苗族自治州", "area":["文山县","砚山县","西畴县","麻栗坡县","马关县","丘北县","广南县","富宁县","其他"]},

        {"name":"西双版纳傣族自治州", "area":["景洪市","勐海县","勐腊县","其他"]},

        {"name":"其他", "area":["其他"]}

    ]},

    { "name": "西藏", "city":[

        {"name":"拉萨", "area":["城关区","林周县","当雄县","尼木县","曲水县","堆龙德庆县","达孜县","墨竹工卡县","其他"]},

        {"name":"那曲地区", "area":["那曲县","嘉黎县","比如县","聂荣县","安多县","申扎县","索县","班戈县","巴青县","尼玛县","其他"]},

        {"name":"昌都地区", "area":["昌都县","江达县","贡觉县","类乌齐县","丁青县","察雅县","八宿县","左贡县","芒康县","洛隆县","边坝县","其他"]},

        {"name":"林芝地区", "area":["林芝县","工布江达县","米林县","墨脱县","波密县","察隅县","朗县","其他"]},

        {"name":"山南地区", "area":["乃东县","扎囊县","贡嘎县","桑日县","琼结县","曲松县","措美县","洛扎县","加查县","隆子县","错那县","浪卡子县","其他"]},

        {"name":"日喀则地区", "area":["日喀则市","南木林县","江孜县","定日县","萨迦县","拉孜县","昂仁县","谢通门县","白朗县","仁布县","康马县","定结县","仲巴县","亚东县","吉隆县","聂拉木县","萨嘎县","岗巴县","其他"]},

        {"name":"阿里地区", "area":["噶尔县","普兰县","札达县","日土县","革吉县","改则县","措勤县","其他"]},

        {"name":"其他", "area":["其他"]}

    ]},

    { "name": "陕西", "city":[

        {"name":"西安", "area":["莲湖区","新城区","碑林区","雁塔区","灞桥区","未央区","阎良区","临潼区","长安区","高陵县","蓝田县","户县","周至县","其他"]},

        {"name":"铜川", "area":["耀州区","王益区","印台区","宜君县","其他"]},

        {"name":"宝鸡", "area":["渭滨区","金台区","陈仓区","岐山县","凤翔县","陇县","太白县","麟游县","扶风县","千阳县","眉县","凤县","其他"]},

        {"name":"咸阳", "area":["秦都区","渭城区","杨陵区","兴平市","礼泉县","泾阳县","永寿县","三原县","彬县","旬邑县","长武县","乾县","武功县","淳化县","其他"]},

        {"name":"渭南", "area":["临渭区","韩城市","华阴市","蒲城县","潼关县","白水县","澄城县","华县","合阳县","富平县","大荔县","其他"]},

        {"name":"延安", "area":["宝塔区","安塞县","洛川县","子长县","黄陵县","延川县","富县","延长县","甘泉县","宜川县","志丹县","黄龙县","吴起县","其他"]},

        {"name":"汉中", "area":["汉台区","留坝县","镇巴县","城固县","南郑县","洋县","宁强县","佛坪县","勉县","西乡县","略阳县","其他"]},

        {"name":"榆林", "area":["榆阳区","清涧县","绥德县","神木县","佳县","府谷县","子洲县","靖边县","横山县","米脂县","吴堡县","定边县","其他"]},

        {"name":"安康", "area":["汉滨区","紫阳县","岚皋县","旬阳县","镇坪县","平利县","石泉县","宁陕县","白河县","汉阴县","其他"]},

        {"name":"商洛", "area":["商州区","镇安县","山阳县","洛南县","商南县","丹凤县","柞水县","其他"]},

        {"name":"其他", "area":["其他"]}

    ]},

    { "name": "甘肃", "city":[

        {"name":"兰州", "area":["城关区","七里河区","西固区","安宁区","红古区","永登县","皋兰县","榆中县","其他"]},

        {"name":"嘉峪关", "area":["嘉峪关市","其他"]},

        {"name":"金昌", "area":["金川区","永昌县","其他"]},

        {"name":"白银", "area":["白银区","平川区","靖远县","会宁县","景泰县","其他"]},

        {"name":"天水", "area":["清水县","秦安县","甘谷县","武山县","张家川回族自治县","北道区","秦城区","其他"]},

        {"name":"武威", "area":["凉州区","民勤县","古浪县","天祝藏族自治县","其他"]},

        {"name":"酒泉", "area":["肃州区","玉门市","敦煌市","金塔县","肃北蒙古族自治县","阿克塞哈萨克族自治县","安西县","其他"]},

        {"name":"张掖", "area":["甘州区","民乐县","临泽县","高台县","山丹县","肃南裕固族自治县","其他"]},

        {"name":"庆阳", "area":["西峰区","庆城县","环县","华池县","合水县","正宁县","宁县","镇原县","其他"]},

        {"name":"平凉", "area":["崆峒区","泾川县","灵台县","崇信县","华亭县","庄浪县","静宁县","其他"]},

        {"name":"定西", "area":["安定区","通渭县","临洮县","漳县","岷县","渭源县","陇西县","其他"]},

        {"name":"陇南", "area":["武都区","成县","宕昌县","康县","文县","西和县","礼县","两当县","徽县","其他"]},

        {"name":"临夏回族自治州", "area":["临夏市","临夏县","康乐县","永靖县","广河县","和政县","东乡族自治县","积石山保安族东乡族撒拉族自治县","其他"]},

        {"name":"甘南藏族自治州", "area":["合作市","临潭县","卓尼县","舟曲县","迭部县","玛曲县","碌曲县","夏河县","其他"]},

        {"name":"其他", "area":["其他"]}

    ]},

    { "name": "青海", "city":[

        {"name":"西宁", "area":["城中区","城东区","城西区","城北区","湟源县","湟中县","大通回族土族自治县","其他"]},

        {"name":"海东地区", "area":["平安县","乐都县","民和回族土族自治县","互助土族自治县","化隆回族自治县","循化撒拉族自治县","其他"]},

        {"name":"海北藏族自治州", "area":["海晏县","祁连县","刚察县","门源回族自治县","其他"]},

        {"name":"海南藏族自治州", "area":["共和县","同德县","贵德县","兴海县","贵南县","其他"]},

        {"name":"黄南藏族自治州", "area":["同仁县","尖扎县","泽库县","河南蒙古族自治县","其他"]},

        {"name":"果洛藏族自治州", "area":["玛沁县","班玛县","甘德县","达日县","久治县","玛多县","其他"]},

        {"name":"玉树藏族自治州", "area":["玉树县","杂多县","称多县","治多县","囊谦县","曲麻莱县","其他"]},

        {"name":"海西蒙古族藏族自治州", "area":["德令哈市","格尔木市","乌兰县","都兰县","天峻县","其他"]},

        {"name":"其他", "area":["其他"]}

    ]},

    { "name": "宁夏", "city":[

        {"name":"银川", "area":["兴庆区","西夏区","金凤区","灵武市","永宁县","贺兰县","其他"]},

        {"name":"石嘴山", "area":["大武口区","惠农区","平罗县","其他"]},

        {"name":"吴忠", "area":["利通区","青铜峡市","盐池县","同心县","其他"]},

        {"name":"固原", "area":["原州区","西吉县","隆德县","泾源县","彭阳县","其他"]},

        {"name":"中卫", "area":["沙坡头区","中宁县","海原县","其他"]},

        {"name":"其他", "area":["其他"]}

    ]},

    { "name": "新疆", "city":[

        {"name":"乌鲁木齐", "area":["天山区","沙依巴克区","新市区","水磨沟区","头屯河区","达坂城区","东山区","乌鲁木齐县","其他"]},

        {"name":"克拉玛依", "area":["克拉玛依区","独山子区","白碱滩区","乌尔禾区","其他"]},

        {"name":"吐鲁番地区", "area":["吐鲁番市","托克逊县","鄯善县","其他"]},

        {"name":"哈密地区", "area":["哈密市","伊吾县","巴里坤哈萨克自治县","其他"]},

        {"name":"和田地区", "area":["和田市","和田县","洛浦县","民丰县","皮山县","策勒县","于田县","墨玉县","其他"]},

        {"name":"阿克苏地区", "area":["阿克苏市","温宿县","沙雅县","拜城县","阿瓦提县","库车县","柯坪县","新和县","乌什县","其他"]},

        {"name":"喀什地区", "area":["喀什市","巴楚县","泽普县","伽师县","叶城县","岳普湖县","疏勒县","麦盖提县","英吉沙县","莎车县","疏附县","塔什库尔干塔吉克自治县","其他"]},

        {"name":"克孜勒苏柯尔克孜自治州", "area":["阿图什市","阿合奇县","乌恰县","阿克陶县","其他"]},

        {"name":"巴音郭楞蒙古自治州", "area":["库尔勒市","和静县","尉犁县","和硕县","且末县","博湖县","轮台县","若羌县","焉耆回族自治县","其他"]},

        {"name":"昌吉回族自治州", "area":["昌吉市","阜康市","奇台县","玛纳斯县","吉木萨尔县","呼图壁县","木垒哈萨克自治县","米泉市","其他"]},

        {"name":"博尔塔拉蒙古自治州", "area":["博乐市","精河县","温泉县","其他"]},

        {"name":"石河子", "area":["石河子"]},

        {"name":"阿拉尔", "area":["阿拉尔"]},

        {"name":"图木舒克", "area":["图木舒克"]},

        {"name":"五家渠", "area":["五家渠"]},

        {"name":"伊犁哈萨克自治州", "area":["伊宁市","奎屯市","伊宁县","特克斯县","尼勒克县","昭苏县","新源县","霍城县","巩留县","察布查尔锡伯自治县","塔城地区","阿勒泰地区","其他"]},

        {"name":"其他", "area":["其他"]}

    ]},

    { "name": "台湾", "city":[

        {"name":"台湾", "area":["台北市","高雄市","台北县","桃园县","新竹县","苗栗县","台中县","彰化县","南投县","云林县","嘉义县","台南县","高雄县","屏东县","宜兰县","花莲县","台东县","澎湖县","基隆市","新竹市","台中市","嘉义市","台南市","其他"]},

        {"name":"其他", "area":["其他"]}

    ]},

    { "name": "澳门", "city":[

        {"name":"澳门", "area":["花地玛堂区","圣安多尼堂区","大堂区","望德堂区","风顺堂区","嘉模堂区","圣方济各堂区","路凼","其他"]}

    ]},

    { "name": "香港", "city":[

        {"name":"香港", "area":["中西区","湾仔区","东区","南区","深水埗区","油尖旺区","九龙城区","黄大仙区","观塘区","北区","大埔区","沙田区","西贡区","元朗区","屯门区","荃湾区","葵青区","离岛区","其他"]}

    ]},

    { "name": "钓鱼岛", "city":[

        {"name":"钓鱼岛", "area":["钓鱼岛"]}

    ]}

];
;(function(){
	var ua = navigator.userAgent.toLowerCase();
	var Common = {
		gotoPin:function(num){
			$('.wrapper .pin').removeClass('current');
			$('.wrapper .pin').eq(num).addClass('current');
		},
		getParameterByName:function(name){
			name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
			var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
			var results = regex.exec(location.search);
			return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
		},
		setParameterByName:function(name,value){
			var query = location.search.substring(1,location.search.length);
			result = query;
			var queryArr = query.split('&');
			//update arr
			var newQuery = '';
			for(var i=0;i<queryArr.length;i++){
				if(queryArr[i].indexOf(name)>-1){
					queryArr[i] = name + '=' + value;
				}
				newQuery = newQuery+queryArr[i]+'&';
			};

			return '?'+newQuery;
		},
        hashRoute:function(){
            var hasTag = location.hash;
            if(hasTag.indexOf('#page=')>-1){
                var hashArr = hasTag.split('=');
                //console.log()
                if(hashArr[1] < $('.pin').length){
                    Common.gotoPin(hashArr[1]);
                }else{
                    Common.gotoPin(0);
                }
            }
        },
		msgBox:{
			add:function(msg,long){
				if(long){
					$('body').append('<div class="ajaxpop msgbox minwidthbox"><div class="loading">'+msg+'</div></div>');
				}else{
					$('body').append('<div class="ajaxpop msgbox"><div class="loading"><div class="icon-loading"></div>'+msg+'</div></div>');
				}
			},
			remove:function(){
				$('.ajaxpop').remove();
			}
		},
		errorMsg : {
			add:function(ele,msg){

				for(var i in ele.childNodes){
					if(ele.childNodes[i].className == 'error'){
						ele.childNodes[i].textContent = msg;
						return true;
					}else{
						if(i==ele.childNodes.length-1){
							var newDiv = document.createElement('div');
							newDiv.textContent = msg;
							newDiv.className = 'error';
							ele.appendChild(newDiv);
						}
					}
				}
			},
			remove:function(ele){

				for(var i in ele.childNodes){
					if(ele.childNodes[i].className == 'error'){
						ele.childNodes[i].parentNode.removeChild(ele.childNodes[i]);
						return;
					}
				}
			}
		},
		errorMsgBox : {
			add:function(msg){
				if(!$('.msgbox').length){
					$('#pin-fillform').append('<div class="msgbox">'+msg+'</div>');
				}else{
					$('#pin-fillform .msgbox').html(msg);
				}
				var rvMsgBox = setTimeout(function(){
					$('.msgbox').remove();
				},3000);
			},
			remove:function(ele){
				if($('.msgbox').length){
					$('.msgbox').remove();
				}
			}
		},
		alertBox:{
			add:function(msg){
				$('body').append('<div class="alertpop msgbox"><div class="inner"><div class="msg">'+msg+'</div><div class="btn-alert-ok">关闭</div></div></div>');
			},
			remove:function(){
				$('.alertpop').remove();
			}
		},
        //lotteryResultPop:{
        //    add:function(id,title,des){
        //        var lotteryHtml = '<div class="popup pop-lottery-result show" id="'+id+'">'+
        //            '<div class="inner">'+
        //            '<div class="f-2"></div>'+
        //            '<div class="msg">'+
        //            '<div class="f-1"></div>'+
        //            '<div class="f-3"></div>'+
        //            '<div class="result-content">'+
        //            '<h3 class="subtitle">'+
        //            '<span>'+title+'</span>'+
        //            '</h3>'+
        //            '<div class="des">'+des+'</div>'+
        //            '</div>'+
        //            '</div>'+
        //            '<div class="btn-close">关闭</div>'+
        //            '</div>'+
        //            '</div>';
        //        $('body').append(lotteryHtml);
        //    },
        //    remove:function(){
        //        $('.pop-lottery-result').remove();
        //    }
        //},
		overscroll: function(el){
			el.addEventListener('touchstart', function() {
				var top = el.scrollTop
					, totalScroll = el.scrollHeight
					, currentScroll = top + el.offsetHeight
				//If we're at the top or the bottom of the containers
				//scroll, push up or down one pixel.
				//
				//this prevents the scroll from "passing through" to
				//the body.
				console.log(currentScroll);
				if(top === 0) {
					el.scrollTop = 1
				} else if(currentScroll === totalScroll) {
					el.scrollTop = top - 1
				}
			});
			el.addEventListener('touchmove', function(evt) {
				//if the content is actually scrollable, i.e. the content is long enough
				//that scrolling can occur
				if(el.offsetHeight < el.scrollHeight)
					evt._isScroller = true
			})
		},


	};


	this.Common = Common;

}).call(this);

var isScroll=false;
var noBounce = function() {
	var module = {};

	var settings = {
		animate: false
	};

	var track = [];

	var velocity = {
		x: 0,
		y: 0
	};

	var vector = {
		subtraction: function(v1, v2) {
			return {
				x: v1.x - v2.x,
				y: v1.y - v2.y
			};
		},
		length: function(v) {
			return Math.sqrt((v.x * v.x) + (v.y * v.y));
		},
		unit: function(v) {
			var length = vector.length(v);
			v.x /= length;
			v.y /= length;
		},
		skalarMult: function(v, s) {
			v.x *= s;
			v.y *= s;
		}
	};

	var requestAnimFrame = (function() {
		return window.requestAnimationFrame ||
			window.webkitRequestAnimationFrame ||
			window.mozRequestAnimationFrame ||
			window.oRequestAnimationFrame ||
			window.msRequestAnimationFrame ||
			function(callback) {
				window.setTimeout(callback, 1000 / 60);
			};
	})();

	function handleTouchStart(evt) {
		var point,
			touch;

		touch = evt.changedTouches[0];
		point = {
			x: touch.clientX,
			y: touch.clientY,
			timeStamp: evt.timeStamp
		};
		track = [point];
	}

	function handleTouchMove(evt) {
		var point,
			touch;


		if(isScroll){
			//touch = evt.changedTouches[0];
			//point = {
			//	x: touch.clientX,
			//	y: touch.clientY,
			//	timeStamp: evt.timeStamp
			//};
			//track.push(point);
			//doScroll();
			evt.stopPropagation();
			return;
		}
		evt.preventDefault();


	}

	function handleTouchEnd(evt) {
		if (track.length > 2 && settings.animate) {
			velocity = calcVelocity();
			requestAnimFrame(animate);
		}
	}

	function calcVelocity() {
		var p1,
			p2,
			v,
			timeDiff,
			length;

		p1 = track[0];
		p2 = track[track.length - 1];
		timeDiff = p2.timeStamp - p1.timeStamp;
		v = vector.subtraction(p2, p1);
		length = vector.length(v);
		vector.unit(v);
		vector.skalarMult(v, length / timeDiff * 20);
		return v;
	}

	function doScroll() {
		var p1,
			p2,
			x,
			y;

		if (track.length > 1) {
			p1 = track[track.length - 1];
			p2 = track[track.length - 2];
			x = p2.x - p1.x;
			y = p2.y - p1.y;
			requestAnimFrame(function() {
				window.scrollBy(x, y);
			});
		}
	}

	function animate() {
		scrollBy(-velocity.x, -velocity.y);
		vector.skalarMult(velocity, 0.95);
		if (vector.length(velocity) > 0.2) {
			requestAnimFrame(animate);
		}
	}

	//Returns true if it is a DOM element
	function isElement(o) {
		return (
			typeof HTMLElement === "object" ? o instanceof HTMLElement : //DOM2
			o && typeof o === "object" && o !== null && o.nodeType === 1 && typeof o.nodeName === "string"
		);
	}

	module.init = function(options) {
		if (typeof options.animate === "boolean") {
			settings.animate = options.animate;
		}
		if (isElement(options.element)) {
			settings.element = options.element;
		}

		var element = settings.element || document;

		element.addEventListener("touchstart", handleTouchStart);
		element.addEventListener("touchmove", handleTouchMove);
		element.addEventListener("touchend", handleTouchEnd);
		element.addEventListener("touchcancel", handleTouchEnd);
		element.addEventListener("touchleave", handleTouchEnd);
	};

	return module;
}();

noBounce.init({
	animate: false
});

$(document).ready(function(){

//	close alert pop
	$('body').on('touchstart','.btn-alert-ok',function(){
		$(this).parent().parent('.alertpop').remove();
	});
	//Common.overscroll(document.querySelector('.wrapper'));




});




/*All the api collection*/
Api = {
    //submit user info
    //{
    //    name: '张三',
    //        tel: '13112345678',
    //    province: '上海',
    //    city: '上海',
    //    area: '黄浦区',
    //    address: '湖滨路'
    //}
    //Form submit of the freetrial
    submitForm_freetrial:function(obj,callback){
        Common.msgBox.add('loading...');
        $.ajax({
            url:'/api/giftinfo',
            type:'POST',
            dataType:'json',
            data:obj,
            success:function(data){
                Common.msgBox.remove();
                return callback(data);
                //status=1 有库存
            }
        });

        //return callback({
        //    status:0,
        //    msg:'fillform'
        //})


    },

    //Form submit of the luckydraw
    submitForm_luckydraw:function(obj,callback){
        Common.msgBox.add('loading...');
        $.ajax({
            url:'/api/lotteryinfo',
            type:'POST',
            dataType:'json',
            data:obj,
            success:function(data){
                Common.msgBox.remove();
                return callback(data);
                //status=1 有库存
            }
        });

        //return callback({
        //    status:0,
        //    msg:'fillform'
        //})


    },

    //抽奖API
    lottery:function(callback){
        Common.msgBox.add('抽奖中...');
        $.ajax({
            url:'/api/lottery',
            type:'POST',
            dataType:'json',
            success:function(data){
                Common.msgBox.remove();
                return callback(data);
            }
        });

        //return callback({
        //    status:1,
        //    msg:'提交成功'
        //});


    },

    //luckydraw status api===luckydrawstatus
    luckydrawstatus:function(callback){
        Common.msgBox.add('loading...');
        $.ajax({
            url:'/api/luckydrawstatus',
            type:'POST',
            dataType:'json',
            success:function(data){
                Common.msgBox.remove();
                return callback(data);
            }
        });


    },

    getImgValidateCode:function(callback){
        Common.msgBox.add('loading...');
        $.ajax({
            url:'/api/picturecode',
            type:'POST',
            dataType:'json',
            success:function(data){
                Common.msgBox.remove();
                return callback(data);
            }
        });

        //return callback({
        //    status:1,
        //    msg:'提交成功'
        //});


    },

    checkImgValidateCode:function(obj,callback){
        Common.msgBox.add('loading...');
        $.ajax({
            url:'/api/checkpicture',
            type:'POST',
            dataType:'json',
            data:obj,
            success:function(data){
                Common.msgBox.remove();
                return callback(data);
            }
        });

        //return callback({
        //    status:1,
        //    msg:'提交成功'
        //});


    },


    //sent message validate code
    //mobile
    sendMsgValidateCode:function(obj,callback){
        Common.msgBox.add('loading...');
        $.ajax({
            url:'/api/phonecode',
            type:'POST',
            dataType:'json',
            data:obj,
            success:function(data){
                Common.msgBox.remove();
                return callback(data);
            }
        });

        //return callback({
        //    status:1,
        //    msg:'提交成功'
        //});


    },


};
//;(function(){
//
//    this.weixinshare = weixinshare;
//}).call(this);
function weixinshare(){
    //wx.config({
    //    debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
    //    appId: data.appId, // 必填，公众号的唯一标识
    //    timestamp: data.timestamp, // 必填，生成签名的时间戳
    //    nonceStr: data.nonceStr, // 必填，生成签名的随机串
    //    signature: data.signature,// 必填，签名，见附录1
    //    jsApiList: ['onMenuShareAppMessage','onMenuShareTimeline'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
    //});
    wx.ready(function(){

        // config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，所以如果需要在页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，则可以直接调用，不需要放在ready函数中。
        // “基本类”按钮详见附录3
        wx.hideAllNonBaseMenuItem();
    });
};

$(document).ready(function(){
    weixinshare();

});
/*For join page
 * Inclue two function, one is load new qr for each person, another is show rule popup
 * */
;(function(){
    var controller = function(){
        this.disableClick = false;
    };
    //init
    controller.prototype.init = function(){
        var self = this;

        var timeStart = 0,
            step= 1,
            isTrueNext = false,
            isFalseNext = false;
        var loadingAni = setInterval(function(){
            if(timeStart>100){
                isFalseNext = true;
                if(isTrueNext){
                    self.startUp();
                }
                clearInterval(loadingAni);
                return;
            };
            if(timeStart==step){
                $('.animate-flower').addClass('fadenow');
            }
            $('.loading-num .num').html(timeStart);
            timeStart += step;
        },50);

        var baseurl = ''+'/src/dist/images/';
        var imagesArray = [
            baseurl + 'preload-flower.jpg',
            baseurl + 'preload-bg.jpg',
            baseurl + 'logo.png',
            baseurl + 'ani-1.png',
            baseurl + 'ani-2.png',
            baseurl + 'ani-3.png',
            baseurl + 'ani-5.png',
            baseurl + 'bg.jpg',
            baseurl + 'btn.png',
            baseurl + 'tag-new.png',
            baseurl + 'f-1.png',
            baseurl + 'fleurs-2.png',
            baseurl + 'fleurs.png',
            baseurl + 'foreground-1.png',
            baseurl + 'gift-flower.png',
            baseurl + 'guide-share.png',
            baseurl + 'landing-1.png',
            baseurl + 'pop-bg.png',
            baseurl + 'text.png'
        ];

        var i = 0,j= 0;
        new preLoader(imagesArray, {
            onProgress: function(){
                i++;
                //var progress = parseInt(i/imagesArray.length*100);
                //console.log(progress);
                //$('.preload .v-content').html(''+progress+'%');
                //console.log(i+'i');
            },
            onComplete: function(){
                isTrueNext  = true;
                if(isFalseNext){
                    self.startUp();
                }
            }
        });


    };

    controller.prototype.startUp = function(){
        var self = this;
        $('.preload').remove();
        $('.wrapper').addClass('fade');
        if(isSubmit){
            Common.gotoPin(1);
        }else{
            self.loadFormPage();
        }

        self.bindEvent();
        self.showAllProvince();

        //test
        //Common.hashRoute();


    };
    controller.prototype.loadFormPage = function(){
        var self = this;
        self.getValidateCode();
        Common.gotoPin(0);

    };

    //bind Events
    controller.prototype.bindEvent = function(){
        var self = this;

        /*
         * submit the form of freetrial
         * if isTransformedOld is true, submit it and then call lottery api
         * if isTransformedOld is false, submit it and then call gift api
         * */
        $('.btn-submit').on('touchstart',function(){
            _hmt.push(['_trackEvent', 'button', 'click', 'submitFreeTrialForm']);
            if(self.validateForm()){
                //name mobile province city area address
                var inputNameVal = $('#input-name').val(),
                    inputMobileVal = $('#input-mobile').val(),
                    inputAddressVal = $('#input-address').val(),
                    inputMsgCodeVal = $('#input-validate-message-code').val(),
                    selectProvinceVal = $('#select-province').val(),
                    selectCityVal = $('#select-city').val(),
                    selectDistrictVal = $('#select-district').val();
                Api.submitForm_freetrial({
                    name:inputNameVal,
                    mobile:inputMobileVal,
                    province:selectProvinceVal,
                    city:selectCityVal,
                    msgCode:inputMsgCodeVal,
                    area:selectDistrictVal,
                    address:inputAddressVal
                },function(data){
                    if(data.status==1){
                        Common.gotoPin(1);
                    }else{
                        Common.alertBox.add(data.msg);
                    }
                });
            }

        });

        //    switch the province
        var curProvinceIndex = 0;
        $('#select-province').on('change',function(){
            curProvinceIndex = document.getElementById('select-province').selectedIndex;
            self.showCity(curProvinceIndex);
        });

        $('#select-city').on('change',function(){
            var curCityIndex = document.getElementById('select-city').selectedIndex;
            self.showDistrict(curProvinceIndex,curCityIndex);
        });

        $('#select-district').on('change',function(){
            var districtInputEle = $('#input-text-district'),
                districtSelectEle = $('#select-district');
            var curCityIndex = document.getElementById('select-district').selectedIndex;
            districtInputEle.val(districtSelectEle.val());
        });


        //    share function
        weixinshare({
            title1: 'KENZO 关注有礼  | 全新果冻霜，夏日清爽礼赠',
            des: 'KENZO白莲果冻霜，让你清爽一夏~',
            link: window.location.origin,
            img: window.location.origin+'/src/dist/images/share.jpg'
        },function(){
           // self.shareSuccess();

        });

        //    imitate share function on pc====test
        //    $('.share-popup .guide-share').on('touchstart',function(){
        //        self.shareSuccess();
        //    });

        //switch validate code
        $('.validate-code').on('touchstart', function(){
            self.getValidateCode();
        });

        /*
         * validate phonenumber first
         * Get message validate code,check image validate code
         * if image validate code is right
         * */
        $('.btn-get-msg-code').on('touchstart', function(){
            if(self.disableClick) return;
            if(!$('#input-mobile').val()){
                Common.errorMsgBox.add('手机号码不能为空');
            }else{
                var reg=/^1\d{10}$/;
                if(!(reg.test($('#input-mobile').val()))){
                    validate = false;
                    Common.errorMsgBox.add('手机号格式错误，请重新输入');
                }else{
                    if(!$('#input-validate-code').val()){
                        Common.alertBox.add('你的验证码不能为空');
                        return;
                    }
                    Api.checkImgValidateCode({
                        picture:$('#input-validate-code').val()
                    },function(data){
                        if(data.status == 1){
                            //start to count down and sent message to your phone
                            Api.sendMsgValidateCode({
                                mobile:$('#input-mobile').val()
                            },function(json){
                                if(json.status==1){
                                    //console.log('开始倒计时');
                                    self.countDown();
                                    self.disableClick = true;
                                }else{
                                    Common.alertBox.add(json.msg);
                                }
                            });
                        }else{
                            Common.alertBox.add('验证码输入错误，请重新输入');
                            self.getValidateCode();
                        }
                    });
                }
            }

        });


        /*
         * For share tips overlay,click will disappear
         * */
        $('.share-popup').on('touchstart', function(e){
            if(e.target.className.indexOf('.share-popup')){
                $('.share-popup').removeClass('show');
            }
        });

    };

    /*
     * Countdown
     * Disabled click the button untill the end the countdown
     * */
    controller.prototype.countDown = function(){
        var self = this;
        self.disableClick = true;
        $('.btn-get-msg-code').addClass('disabled');
        var maxSeconds = 60;
        var ele = $('.btn-get-msg-code .second');
        var aaa = setInterval(function(){
            maxSeconds--;
            ele.text('('+maxSeconds+'s'+')');
            if(maxSeconds<1){
                self.disableClick = false;
                ele.text('');
                $('.btn-get-msg-code').removeClass('disabled');
                clearInterval(aaa);
            }
        },1000);
    };

    //Api for img validate code
    controller.prototype.getValidateCode = function(){
        Api.getImgValidateCode(function(data){
            //console.log(data);
            if(data.status==1){
                $('.validate-code-img').html('<img src="data:image/jpeg;base64,'+data.picture+'" />');
                //var codeImg = new Image();
                //codeImg.onload = function(){
                //
                //}
                //codeImg.src = data.picture;
            }
        });
    };


    //province city and district
    controller.prototype.showAllProvince = function(){
        var self = this;
        //    list all province
        var provinces = '';
        var provinceSelectEle = $('#select-province'),
            provinceInputEle = $('#input-text-province');
        region.forEach(function(item){
            provinces = provinces+'<option value="'+item.name+'">'+item.name+'</option>';
        });
        provinceSelectEle.html(provinces);
        provinceInputEle.val(provinceSelectEle.val());
        self.showCity(0);
        self.showDistrict(0,0);
    };

    controller.prototype.showCity = function(curProvinceId){
        var self = this;
        //    show current cities
        var cities='';
        var provinceSelectEle = $('#select-province'),
            provinceInputEle = $('#input-text-province'),
            citySelectEle = $('#select-city'),
            cityInputEle = $('#input-text-city');
        var cityJson = region[curProvinceId].city;
        cityJson.forEach(function(item,index){
            cities = cities + '<option data-id="'+index+'" value="'+item.name+'">'+item.name+'</option>';
        });
        citySelectEle.html(cities);
        provinceInputEle.val(provinceSelectEle.val());
        cityInputEle.val(citySelectEle.val());
        self.showDistrict(curProvinceId,0);
    };

    controller.prototype.showDistrict = function(curProvinceId,curCityId){
        var self = this;
        var districtSelectEle = $('#select-district'),
            districtInputEle = $('#input-text-district'),
            citySelectEle = $('#select-city'),
            cityInputEle = $('#input-text-city');
        //    show current districts
        var districts = '';
        var districtJson = region[curProvinceId].city[curCityId].area;
        districtJson.forEach(function(item,index){
            districts = districts + '<option data-id="'+index+'" value="'+item+'">'+item+'</option>';
        });
        cityInputEle.val(citySelectEle.val());
        districtSelectEle.html(districts);
        districtInputEle.val(districtSelectEle.val());
    };

    //validation the form
    controller.prototype.validateForm = function(){
        var self = this;
        var validate = true,
            inputName = document.getElementById('input-name'),
            inputMobile = document.getElementById('input-mobile'),
            inputAddress = document.getElementById('input-address'),
            selectProvince = document.getElementById('select-province'),
            selectCity = document.getElementById('select-city'),
            selectDistrict = document.getElementById('select-district');

        if(!inputName.value){
            Common.errorMsgBox.add('请填写姓名');
            validate = false;
        };

        if(!inputMobile.value){
            Common.errorMsgBox.add('手机号码不能为空');
            //Common.errorMsg.add(inputMobile.parentElement,'手机号码不能为空');
            validate = false;
        }else{
            var reg=/^1\d{10}$/;
            if(!(reg.test(inputMobile.value))){
                validate = false;
                Common.errorMsgBox.add('手机号格式错误，请重新输入');
                //Common.errorMsg.add(inputMobile.parentElement,'手机号格式错误，请重新输入');
            }else{
                //Common.errorMsg.remove(inputMobile.parentElement);
            }
        }

        if(!selectProvince.value || selectProvince.value == '省份'){
            //Common.errorMsg.add(selectProvince.parentElement,'请选择省份');
            Common.errorMsgBox.add('请选择省份');
            validate = false;
        }else{
            //Common.errorMsg.remove(selectProvince.parentElement);
        };

        if(!selectCity.value || selectCity.value == '城市' || !selectDistrict.value || selectDistrict.value == '区县' ){
            //Common.errorMsg.add(selectCity.parentElement.parentElement,'请选择城市和区县');
            Common.errorMsgBox.add('请选择城市和区县');
            validate = false;
        }else{
            //Common.errorMsg.remove(selectCity.parentElement);
        };

        if(!inputAddress.value){
            //Common.errorMsg.add(inputAddress.parentElement,'请填写地址');
            Common.errorMsgBox.add('请填写地址');
            validate = false;
        }else{
            //Common.errorMsg.remove(inputAddress.parentElement);
        };

        if(validate){
            return true;
        }
        return false;
    };


    $(document).ready(function(){
//    show form
        var newFollow = new controller();
        newFollow.startUp();

    });

})();