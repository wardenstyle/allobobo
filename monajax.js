/**
 * initialisation XMLHttp request
 * @returns instance
 */
function getxhr()
{
    var xhr;
    if (window.XMLHttpRequest)
    {
        xhr = new XMLHttpRequest();
    }
    else if (window.ActiveXObject)
    {
        try
        {
            xhr = new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch (e)
        {
            xhr = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }
    return xhr;
}

/**
 * fonction pour vérifier la disponibilité des médecins
 * @param : date_complete, id_medecin
 * page concernée : rdv.php
 */
function verifier_creneau()
{
    var medecin = document.getElementById("id_medecin").value;
    var jour = document.getElementById("jour").value;
    var mois = document.getElementById("mois").value;
    var annee = document.getElementById("annee").value;
    var heure = document.getElementById("heures").value;
    var minute = document.getElementById("minutes").value;

    if(jour<10) {var jour = "0"+jour};
    if(mois<10) {var mois = "0"+mois};
    var date_complete = annee+"-"+mois+"-"+jour+" "+heure+":"+minute+":00";
            
    var a = getxhr();

    a.open("POST", "creneaux.php", true);
    a.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    a.onreadystatechange = function()
    { 
        if (a.readyState == 4)
        {
            if (a.status == 200)	
            {
                document.getElementById("resultat").innerHTML = a.responseText;
            }
            else 
            {
                alert("Error code : " + a.status);
            }
        }
    };
    
    a.send("date="+date_complete+"&id_medecin="+medecin);						
}

/**
 * fonction pour vérifier que l'adresse email n'est pas entrée en double
 * page concernée : inscription.php 
 */
function verifier_email()
{
    var email = document.getElementById("email").value;
    var pattern = /^[a-z0-9.-]{2,}@+[a-z0-9.-]{2,}$/i;

    if (pattern.test(email)) {

        var a = getxhr();

        a.open("POST", "inscription_trt.php", true);
        a.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        a.onreadystatechange = function()
        { 
            if (a.readyState == 4)
            {
                if (a.status == 200)	
                {
                    document.getElementById("resultat").innerHTML = a.responseText;
                }
                else 
                {
                    alert("Error code : " + a.status);
                }
            }
        };
        a.send("email="+email);    
    }  
    

}

function verifier_mdp()
{
    var password = document.getElementById("password").value;
    var repeatpassword = document.getElementById("repeatpassword").value;

    if (password.length > 5 && repeatpassword.length >5 )
        {
            var a = getxhr();
            a.open("POST", "inscription_trt.php", true);
            a.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            a.onreadystatechange = function()
            { 
                if (a.readyState == 4)
                {
                    if (a.status == 200)	
                    {
                        document.getElementById("resultat2").innerHTML = a.responseText;
                    }
                    else 
                    {
                        alert("Error code : " + a.status);
                    }
                }
            };
 
            a.send("mdp="+password+"&r_mdp="+repeatpassword);
        }

}