/*
 * engine.js
 * @version 2
 */

function Prodotto()
{
    this.id_prodotto = 0;
    this.attributi = [];
    
    this.aggiungiAttributo = function(id_attributo) {
        //window.alert('aggiunto attributo ' + id_attributo);
        this.attributi.push(id_attributo);
    };
    
    this.rimuoviAttributo = function(id_attributo) {
        
        var index = this.attributi.indexOf(id_attributo);
        
        if(index > 0)
        {
            //window.alert('rimosso ' + id_attributo);
            this.attributi.splice(index, 1);
        }
    };
}

var obj_prodotto = new Prodotto();


function setCaratteristiche(obj){
    //window.alert("setCaratteristiche");
    var $elenco_caratteristiche = $("#elenco_caratteristiche");
    var $step_caratteristiche = $("#selezione_caratteristiche");
    var $step_finale = $("#step_finale");
    
    var $this = obj;
    var idprodesel = $this.attr("data-prod");
    
    $step_finale.hide();

    $.ajax({
            url: "ajax/elenco_caratteristiche.php",
            data: {
                    idprodesel: idprodesel
            },
            type: 'GET',
            success: function(elenco){   
                    //window.alert("passa");
                    if(elenco !== "")
                    {
                        $step_caratteristiche.show();
                        $elenco_caratteristiche.html(elenco);
                    }
                    $("#elenco_modelli").children(".modello").removeClass("selezionato");
                    $this.addClass("selezionato");
            }
    });
}

function selezionaOpzione(obj, cmd){
    //window.alert("selezionaOpzione");
    var $this = obj;
    
    var padre = $this.parent();
    var childs = padre.children(".opzione");
    padre.children(".opzione").removeClass("selezionato");
    
    for (var i = 0; i < childs.length; i++) {
        var child = childs[i];
        obj_prodotto.rimuoviAttributo(child.getAttribute("data-idattr"));
    }

    $this.addClass("selezionato");
    
    if (cmd !== 'fine')
    {
        $("#"+cmd).show();
    }
    else
    {
        $("#step_finale").show();
    }
    obj_prodotto.aggiungiAttributo($this.attr("data-idattr"));
    
}

function calcolaStima(){
    
    var attributi = "";
    
    for (var i = 0; i < (obj_prodotto.attributi.length-1); i++) {
        attributi = attributi + obj_prodotto.attributi[i] + ",";
    }
    attributi = attributi + obj_prodotto.attributi[obj_prodotto.attributi.length-1];
    
    $.ajax({
            url: "ajax/calcola_stima.php",
            data: {
                idprod: obj_prodotto.id_prodotto,
                idattributi: attributi
            },
            type: 'GET',
            success: function(risultato){   
                //window.alert("passa "+risultato);
                $("#stima").text(Number(risultato).toFixed(2));
            }
    });
}


function inviaEmail(){
    var $email = $("#js-email_invia_riepilogo");
    
    var attributi = "";
    
    for (var i = 0; i < (obj_prodotto.attributi.length-1); i++) {
        attributi = attributi + obj_prodotto.attributi[i] + ",";
    }
    attributi = attributi + obj_prodotto.attributi[obj_prodotto.attributi.length-1];
    
    if($email.val() == "")
    {
        $("#risultato_invia_riepilogo_err").show();
        $("#risultato_invia_riepilogo").hide();
    }
    else
    {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (re.test($email.val()))
        {
            $("#risultato_invia_riepilogo_err").hide();
            
            $.ajax({
                    url: "ajax/invia_email.php",
                    data: {
                        idprod: obj_prodotto.id_prodotto,
                        idattributi: attributi,
                        destinatario: $email.val()
                    },
                    type: 'GET',
                    success: function(risultato){   
                        //window.alert("passa "+risultato);
                    }
            });
   
            $("#risultato_invia_riepilogo").text('Una email con il riepilogo è stata inviata a '+$email.val());
            $("#risultato_invia_riepilogo").show();
        }
        else
        {
            $("#risultato_invia_riepilogo_err").show();
            $("#risultato_invia_riepilogo").hide();
        }
        
    }
}

$(document).ready(function(){
    var $elenco_device = $("#elenco_device");
    var $step_modello = $("#selezione_modello");
    var $elenco_modelli = $("#elenco_modelli");
    var $step_caratteristiche = $("#selezione_caratteristiche");
    var $step_finale = $("#step_finale");
    
    $elenco_device.children(".js-device").click(function(){
		var $this = $(this);
		var device = $this.attr("data-device");
		$step_caratteristiche.hide();
		$step_finale.hide();
                $step_modello.hide();
                $elenco_modelli.children().remove();
                
                //window.alert('prodotto ' + device);
                obj_prodotto.id_prodotto = device;
    
                $.ajax({
                        url: "ajax/elenco_modelli.php",
                        data: {
                                device: device
                        },
                        type: 'GET',
                        success: function(elenco){   
                                //window.alert("passa");
                                if(elenco !== "")
                                {
                                    $step_modello.toggle();
                                    $elenco_modelli.html(elenco);
                                }
                                $elenco_device.children(".js-device").removeClass("selezionato");
                                $this.addClass("selezionato");

                        }
                });
		
	});
  
});


//APRI POPUP
$("#js-valuta").click(function(){
    
    var modalWrapper = document.querySelector('[data-modal="wrapper"]');
    modalWrapper.classList.add("modal-opened");
    $("#risultato_invia_riepilogo_err").hide();
    $("#risultato_invia_riepilogo").hide();
    calcolaStima();
    window.scrollTo(0, 0);
    
});


