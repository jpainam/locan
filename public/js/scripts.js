//Loading external javascript files
$("head").append('<script type="text/javascript" src="http://localhost/locan/public/js/jquery-ui.js"></script>');
$("head").append('<script type="text/javascript" src="http://localhost/locan/public/js/jquery.dataTables.min.js"></script>');
$("head").append('<script type="text/javascript" src="http://localhost/locan/public/js/codebase/webix.js"></script>');
$("head").append('<script type="text/javascript" src="http://localhost/locan/public/js/jquery.datetimepicker.js"></script>');

var men1_pas = 2;
var men1_bas = true, men1_encour = false;
var men1_tmp = men1_pas;
var men1_t, men1_y = 1, men1_index = 0;
var men1_tab = [], men1_user;

$(document).ready(function () {
    loaded();
});
function loaded(list, id, elem) {
    if (typeof id === 'undefined') {
        var max = $(window).height() - 185;
        $("#menu").css({maxHeight: max});
        var hTitre, hRecapitulatif;

        if ($(".titre").length === 0) {
            hTitre = -22;
        } else {
            hTitre = $(".titre").height();
        }

        if ($(".recapitulatif").length === 0) {
            hRecapitulatif = -18;
        } else {
            hRecapitulatif = $(".recapitulatif").height();
        }

        var h = $("#entete").height() + $(".navigation").height() + hRecapitulatif
                + $(".status").height() + hTitre;
        $(".page").css({height: $(window).height() - h - 100});



        $(document).ajaxStart(function () {
            $("#loading").show();
        }).ajaxStop(function () {
            $("#loading").hide();
        });
        //hauteur des dataTable
        var dHeight;
        if ($(".onglet").length !== 0) {
            dHeight = $(".page").height() - 140;
        } else {
            dHeight = $(".page").height() - 100;
        }

        $.extend($.fn.dataTable.defaults, {
            "aaSorting": [],
            "scrollCollapse": false,
            "scrollY": dHeight,
            "pageLength": 200,
            "paging": true,
            "searching": true,
            "bInfo": true,
            //"dom": '<"tableWrapper"fl>',
            "jQueryUI": true,
            "language": {
                "sProcessing": "Traitement en cours...",
                "sSearch": "Rechercher&nbsp;:",
                "sLengthMenu": "Afficher _MENU_ &eacute;l&eacute;ments",
                "sInfo": "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                "sInfoEmpty": "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
                "sInfoFiltered": "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                "sInfoPostFix": "",
                "sLoadingRecords": "Chargement en cours...",
                "sZeroRecords": "Aucun &eacute;l&eacute;ment &agrave; afficher",
                "sEmptyTable": "Aucune donn&eacute;e disponible dans le tableau",
                "oPaginate": {
                    "sFirst": "Premier",
                    "sPrevious": "Pr&eacute;c&eacute;dent",
                    "sNext": "Suivant",
                    "sLast": "Dernier"
                },
                "oAria": {
                    "sSortAscending": ": activer pour trier la colonne par ordre croissant",
                    "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
                }
            }
        });
        //default datatables


        /*
         * Fonction permettant d'afficher et cacher le menu.
         *
         
         (function () {
         var p_el, i = 0;
         p_el = document.querySelectorAll("#menu-accordeon li > p");
         for (; i < p_el.length; i++) {
         p_el.item(i).addEventListener('click', function (e) {
         var p, lis;
         p = e.target.parentNode;
         lis = p.nextSibling.childNodes;
         if (getComputedStyle(lis[0], false).maxHeight === '240px') {
         for (var j = 0; j < lis.length; j++)
         lis[j].style.maxHeight = '0px';
         p.style.backgroundImage = "-webkit-linear-gradient(top, #729EBF 50%, #333A40 100%)";
         p.style.backgroundImage = "-o-linear-gradient(bottom, #729EBF 50%, #333A40 100%)";
         p.style.backgroundImage = "-moz-linear-gradient(bottom, #729EBF 50%, #333A40 100%)";
         p.style.backgroundImage = "linear-gradient(bottom, #729EBF 50%, #333A40 100%)";
         
         
         } else {
         
         for (var j = 0; j < lis.length; j++)
         lis[j].style.maxHeight = '240px';
         p.style.backgroundImage = "-webkit-linear-gradient(left, white 30%, #729EBF 100%)";
         p.style.backgroundImage = "-o-linear-gradient(left, white 30%, #729EBF 100%)";
         p.style.backgroundImage = "-moz-linear-gradient(left, white 30%, #729EBF 100%)";
         p.style.backgroundImage = "linear-gradient(left, white 30%, #729EBF 100%)";
         
         }
         }, false);
         
         }
         })();*/
    }
    else
    {
        var inc, el, y, lien;
        men1_tab = list;
        inc = parseInt(men1_tab[id - 1]);
        el = elem.parentNode.nextSibling;
        lien = elem.parentNode.lastChild.src.split("/");
        if (inc === 1) {
            y = calculTaille(el);
            lien[lien.length - 1] = "sort_desc_disabled.png";
            el.style.height = y + "px";
        } else {
            el.style.height = 1 + "px";
            lien[lien.length - 1] = "sort_asc_disabled.png";
            el.style.height = 1 + "px";
        }
        elem.parentNode.lastChild.src = replaceAll(",", "/", lien.toString());
    }

    //Definir la langue pour webix
    webix.i18n.setLocale("fr-FR");
}

webix.i18n.locales["fr-FR"] = {
    calendar: {
        monthFull: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"],
        monthShort: ["Jan", "Fév", "Mar", "Avr", "Mai", "Juin", "Juil", "Aoû", "Sep", "Oct", "Nov", "Déc"],
        dayFull: ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"],
        dayShort: ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam"]
    }
};

function deleteRow(_url, name) {
    webix.modalbox({
        title: "Suppression d'une ligne",
        buttons: ["Oui", "Non"],
        width: "300px",
        text: "Etes-vous certain de vouloir supprimer " + name,
        callback: function (result) {
            if (result == 0) {
                document.location = _url;
            }
        }
    });
}
/**
 * utiliser pour afficher les message
 * de warning a l'endroit de l'utilisateur
 * @param {type} sms
 * @returns {undefined}
 * 
 */

function alertWebix(sms) {
    webix.modalbox({
        title: "Alerte",
        buttons: ["Ok"],
        width: "300px",
        text: sms
    });
}
function editRow(_url) {
    document.location = _url;
}
/**
 * Readjuste les colonnes des table lorsqu'on clique sur un onglet
 * @param {array} elts
 * @returns {void}
 */
function reAdjustDataTableColumns(elts) {
    var i;
    for (i = 0; i < elts.length; i++) {
        var el = elts[i];
        if ($("#" + el).length) {
            if ($.fn.DataTable.isDataTable("#" + el)) {
                var table = $("#" + el).DataTable();
                table.columns.adjust().draw();
            }
        }
    }
}
function onglets(premier, actuel, nombre) {
    for (i = premier; i < nombre + 1; i++) {
        if (i === actuel) {
            document.getElementById('tab' + i).className = 'courant';
            document.getElementById('onglet' + i).style.display = 'block';
        } else {
            document.getElementById('tab' + i).className = 'noncourant';
            document.getElementById('onglet' + i).style.display = 'none';
        }
    }
    var array_of_dataTables = ["tab_mat", "tableEnseignants", "tableFinance", "persoTable",
        "tableEleves", "eleveTable", "responsabletable", "onglet2_table", "dataTable2", "dataTable",
        "connexionTable", "droitTable", "tableEnseignements", "tableAbsences1", "tableAbsences2", "tableAbsences3",
        "tableAbsences4", "tableAbsences5", "justificationTable", "tableSuivi", "tableNotes", "tableTotaux", "tableOperation"];
    reAdjustDataTableColumns(array_of_dataTables);
}


/**
 * Permet d'ajouter un style particulier au champs obligatoires
 * @param {array} fields le tableau des champs obligatoires, a definir [champ1, champ2, etc...];
 * @returns {undefined}
 */
function addRequiredFields(fields) {
    for (i = 0; i < fields.length; i++) {
        if (fields[i].val() === "")
            fields[i].addClass("requiredFields");
    }
}
/**
 * Enleve le style appliquee aux champs obligatoire par la fonction requiredFields
 * @param {array} fields
 * @returns {undefined}
 */
function removeRequiredFields(fields) {
    for (i = 0; i < fields.length; i++) {
        fields[i].removeClass("requiredFields");
    }
}

function getCalendar(id) {
    if ($("#" + id).length) {
        calendar = webix.ui({
            view: "datepicker",
            id: id,
            name: id,
            container: id,
            width: 160,
            height: 25,
            placeholder: "JJ-MM-AAAA",
            format: "%D %d %M %Y",
            stringResult: true
        });
        return calendar;
    }
    return null;

}

function tooltip_on(e, ligne, dec) {
    dec = dec || false;

    var posx = 0;
    var posy = 0;
    if (!e)
        e = window.event;
    if (dec) {
        var top = 5;
    } else {
        var top = 110;
    }
    if (e.pageX || e.pageY) {
        posx = e.pageX - 210;
        posy = e.pageY - top;
    } else if (e.clientX || e.clientY) {
        posx = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft - 210;
        posy = e.clientY + document.body.scrollTop + document.documentElement.scrollTop - top;
    }
    document.getElementById('tooltip' + ligne).style.left = posx + 'px';
    document.getElementById('tooltip' + ligne).style.top = posy + 'px';
    document.getElementById('tooltip' + ligne).style.display = 'block';
}

function tooltip_off(ligne) {
    window.off = setTimeout(function () {
        document.getElementById('tooltip' + ligne).style.display = 'none';
    }, 200);
}

function tooltip_stop(ligne) {
    clearTimeout(window.off);
}


/*
 * fonction excuté après chaque millisecond par le setInterval dans clickMenu
 * elle permet d' ouvrir ou fermer progressivement un bloc
 */

function progressif(ul, h, id) {
    men1_encour = true;
    //alert("nb i = "+(++i)+" et les Y= "+y+"  et la taille (bas = "+bas+") = "+h);
    if (men1_y > h && men1_bas) {
        men1_pas = -men1_pas;
        men1_bas = false;
        men1_encour = false;
        ul.style.height = h + 'px';
        clearInterval(men1_t);
        men1_tab[id - 1] = 1;
        ajourIndice();
        return false;
    }
    if (men1_y < men1_tmp && !men1_bas) {
        men1_pas = -men1_pas;
        men1_bas = true;
        men1_encour = false;
        men1_y = 1;
        ul.style.height = men1_y + 'px';
        clearInterval(men1_t);
        men1_tab[id - 1] = 0;
        ajourIndice();
        return false;
    }
    men1_y = men1_y + men1_pas;
    ul.style.height = men1_y + 'px';
}

/*
 * fonction permettant de calculer la taille d'un elle en fonction de son contenu
 */
function calculTaille(ul) {
    var i = 0, x = 0;
    for (; i < ul.childNodes.length; i++)
        x += ul.childNodes.item(i).offsetHeight;
    return x;
}

/*
 * FONCTION ONCLICK SUR LE GROUPE MENU
 * ELLE PERMET DE LANCER L'AFFICHAGE PROGRESSIVE DU MENU
 * ELLE PERMET DE LANCER EN BOUCLE UNE PROCESSUS GRACE AU SETINTERVAL APRES CHAQUE MILLISECONDE
 * ET GARDE L'INDICE DU GROUPE DANS id 
 */
function clickMenu(e, i, id, u) {
    var lien;
    if (men1_encour) {
        return false;
    }
    men1_user = u;
    lien = e.lastChild.src.split("/");
    if (lien[lien.length - 1] === "sort_asc_disabled.png") {
        lien[lien.length - 1] = "sort_desc_disabled.png";
    } else {
        lien[lien.length - 1] = "sort_asc_disabled.png";
    }
    e.lastChild.src = replaceAll(",", "/", lien.toString());

    var h = calculTaille(e.nextSibling);
    //alert("i = "+i+"   index = "+index);
    if (men1_index !== i) {
        men1_index = i;
        if (e.nextSibling.offsetHeight <= 1) {
            men1_y = 1;
            men1_bas = true;
            men1_pas = 2;
        }
        else
        {
            men1_y = (Math.floor(h / Math.abs(men1_pas)) * Math.abs(men1_pas)) + Math.abs(men1_pas);
            men1_bas = false;
            men1_pas = -2;
        }


    }
    men1_t = setInterval(function () {
        progressif(e.nextSibling, h, id);
    }, 1);
}

function sleep(time) {
    var date = new Date().getTime();
    while (new Date().getTime() > (date + time)) {
    }
}


function replaceAll(find, replace, str) {
    return str.replace(new RegExp(find, 'g'), replace);
}
/*
 * FONCTION AJAX PERMETTANT DE RENDRE FIGE LE GROUPE MENU LORS DU RECHARGEMENT DE LA PAGE
 * ELLE RENVOI LES PARAMS SUR LE USER ET LE TABLEAU DU BINAIRE DE SON MENU
 */
function ajourIndice() {
    var _url = $(location).attr("pathname");
    _url = _url.split("/");
    if(_url[2] === ""){
        _url[2] = "etablissement";
    }
    console.log(_url);

    var _chemin = "index";

    if (_url.length === 3) {
        if (_url[2] !== "") {
            _chemin = _url[2];
        }
    }
    if (_url.length === 4) {
        if (_url[3] !== "") {
            _chemin = "./";
        } else {
            _chemin = _url[2];
        }
    }

    $.ajax({
        url: _chemin + "/updateMenu",
        type: "POST",
        dataType: "html",
        global: false,
        data: {
            "tab": replaceAll(",", "", men1_tab.toString()),
            "user": men1_user
        },
        success: function (result) {

        },
        error: function (xhr, status, error) {
            alert("Une erreur s'est produite " + xhr + " " + error);
        }
    });
}

(function (factory) {
    if (typeof define === "function" && define.amd) {
// AMD. Register as an anonymous module.
        define(["../widgets/datepicker"], factory);
    } else {
// Browser globals
        factory(jQuery.datepicker);
    }
}(function (datepicker) {
    datepicker.regional['fr'] = {
        closeText: 'Fermer',
        prevText: 'Précédent',
        nextText: 'Suivant',
        currentText: 'Aujourd\'hui',
        monthNames: ['janvier', 'février', 'mars', 'avril', 'mai', 'juin',
            'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'],
        monthNamesShort: ['janv.', 'févr.', 'mars', 'avr.', 'mai', 'juin',
            'juil.', 'août', 'sept.', 'oct.', 'nov.', 'déc.'],
        dayNames: ['dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'],
        dayNamesShort: ['dim.', 'lun.', 'mar.', 'mer.', 'jeu.', 'ven.', 'sam.'],
        dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
        weekHeader: 'Sem.',
        dateFormat: 'dd/mm/yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''};
    datepicker.setDefaults(datepicker.regional['fr']);
    return datepicker.regional['fr'];
}));


function _getDatepicker(_idinput) {
    if ($("#" + _idinput).length) {        
        var d = $("#" + _idinput).datepicker({
            changeMonth: true,
            defaultDate: "+1w",
            changeYear: true,
            dateFormat: "dd/mm/yy"
        });
        return d;
    }
    return null;
}
var toucheRedirection = function () {
    $('input[type="text"]').keydown(function (e) {
        console.log(e.keyCode);
        if (e.keyCode === 40) {
            //$(this).next('input[type=text]').focus();
            var td = $(this).parent();
            var indice = td.index();
            var tr = td.parent();
            tr = tr.next();
            td = tr.children("td")[indice];
            //console.log(td);
            var input = $(td).children("input");
            console.log(input);
            input.focus();
        } else if (e.keyCode === 38) {
            //$(this).prev('input[type=text]').focus();
            var td = $(this).parent();
            var indice = td.index();
            var tr = td.parent();
            tr = tr.prev();
            td = tr.children("td")[indice];
            //console.log(td);
            var input = $(td).children("input");
            console.log(input);
            input.focus();
        } else if (e.keyCode === 39) {
            //Touche direction vers la droite
            var td = $(this).parent();
            td = td.next();
            var input = td.children("input");
            input.focus();
        } else if (e.keyCode === 37) {
            //Toute direction vers la gauche
            var td = $(this).parent();
            td = td.prev();
            var input = td.children("input");
            input.focus();
        }
    });
}