

//script defilement des activités dans la landing page 
document.addEventListener("DOMContentLoaded",function(){
  const scrollContainer=document.getElementById("scroll-activites");
  const arrowRight=document.getElementById("scroll-arrow-right");
  const arrowLeft=document.getElementById("scroll-arrow-left");


  arrowRight.addEventListener("click",()=>{
    scrollContainer.scrollBy({
      left:300,
      behavior:"smooth"
    })
  })

  arrowLeft.addEventListener("click",()=>{
    scrollContainer.scrollBy({
      left:-300,
      behavior:"smooth"
    })
  })
})
//script pour l'annimation des commentaires
document.addEventListener("DOMContentLoaded",()=>{
  const commentaires=document.querySelectorAll(".commentaire");
  const observer=new IntersectionObserver((entries)=>{
    entries.forEach(entry=>{
      if (entry.isIntersecting) {
        entry.target.classList.add("visible");
      }
    })
  } ,{
    threshold:0.2,
  });
  commentaires.forEach(el=>observer.observe(el));
})



///script pour afficher les sections dans le dashboard de l'utilisateur 
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', function (e) {
      if (this.getAttribute('href').startsWith('#')) {
        e.preventDefault();
        const target = this.getAttribute('href').substring(1);
        document.querySelectorAll('.dashboard-section').forEach(s => s.style.display = 'none');
        document.getElementById(target).style.display = 'block';
      }
    });
  });
});


 //script pour l'insccrition aux cours 
 document.addEventListener("DOMContentLoaded",function(){
  const boutons = document.querySelectorAll(".inscrire-btn");
  const modal =new bootstrap.Modal(document.getElementById('modalReservation'));
  const form =document.getElementById('formReservation');

  boutons.forEach(btn=>{
    btn.addEventListener("click",()=>{

      //simulation d'un utilisateur connécté
      const utilisateurConnecte=localStorage.getItem("utilisateurConnecte");
 console.log("utilisateurConnecte =", utilisateurConnecte);
      if (!utilisateurConnecte) {
        //rediriger vers la page de connexion
        alert("utilisateur non connecté");
        window.location.href="inscription.html";
        return ;       
      }
      const cours =btn.dataset.cours;
      document.getElementById("coursSelectionne").value=cours;
      modal.show();
    });
  });

  form.addEventListener("submit",function(e){
    e.preventDefault();

    const cours =document.getElementById("coursSelectionne").value;
    const date=document.getElementById("dateCours").value;
    const heure=document.getElementById("heureCours").value;

    if (!date||!heure) {
      alert("Merci de choisir une date et un créneau");
      return;
      
    }

    const reservation =`${cours}- ${date} à ${heure}`;
    let coursInscrits=JSON.parse(localStorage.getItem("mesCours")) || [];


    if (!coursInscrits.includes(reservation)) {
      coursInscrits.push(reservation);
      localStorage.setItem("mesCours", JSON.stringify(coursInscrits));
      alert(`Réservé ${reservation}`);
      modal.hide();
      form.reset();
      
    }else{
      alert("Vous etes deja inscrit à ce cour à ce créneau ")
    }
  })
 })

 //le script qui va gerer le remplissage des champs dans le formulaire de demande d'un devis (utilisateur connécté ou non)
 document.addEventListener("DOMContentLoaded",function(){
  const estConnecte=localStorage.getItem("utilisateurConnecte");


  if(estConnecte==="true")
{
//si l'utilisateur est connécté les champs seront préremplits
const nom= localStorage.getItem("nom");

const email= localStorage.getItem("email");

if(nom) document.querySelector('input[nom="nom"').value=nom;

if(email) document.querySelector('input[nom="email"').value=email;

//si l'utilisateur n'est pas connecté , il remplit manuellement



} 


})


//fonction pour l'affichage dans la nav bar qui change en fonction de utilisateur connecté ou non


document.addEventListener("DOMContentLoaded",function(){
  const estConnecte = localStorage.getItem("utilisateurConnecte");
  const btnConnexion = document.getElementById("btnConnexion");
  const btnCompte = document.getElementById("btnCompte");


  if(estConnecte==="true"){
    btnConnexion.classList.add("d-none");
    btnCompte.classList.remove("d-none");

  }
})


// Récupération du token dans l'URL
// Vérifie si l'URL est exactement localhost/reset-mdps.html
if (window.location.href === 'http://localhost/reset-mdps.html' || 
  window.location.href === 'https://localhost/reset-mdps.html') {
  
  const urlParams = new URLSearchParams(window.location.search);
  const token = urlParams.get('token');

  if (token) {
      console.log("Token reçu :", token);

      document.getElementById("resetForm").addEventListener("submit", function(e) {
          e.preventDefault();
          
          const newPassword = document.getElementById("nouveau").value;

          fetch("reinitialiser.php", {
              method: "POST",
              headers: {
                  "Content-Type": "application/x-www-form-urlencoded"
              },
              body: `token=${encodeURIComponent(token)}&nouveau=${encodeURIComponent(newPassword)}`
          })
          .then(res => res.text())
          .then(data => {
              alert(data); // message de succès ou d'erreur
              if (data.includes("succès")) {
                  window.location.href = "inscription.html";
              }
          })
          .catch(error => {
              console.error("Erreur lors de la réinitialisation:", error);
              alert("Une erreur est survenue lors de la réinitialisation.");
          });
      });

  } else {
      alert("Aucun token fourni.");
      // Redirection si aucun token n'est présent
      window.location.href = "inscription.html";
  }
} else {
  console.log("Ce script ne doit s'exécuter que sur la page reset-mdps.html");
}


function checkUrlParams() {
  // Récupérer les paramètres de l'URL
  const urlParams = new URLSearchParams(window.location.search);
  
  // Parcourir tous les paramètres de l'URL
  urlParams.forEach((value, key) => {
      // Si le paramètre n'est pas 'token', afficher une alerte
      if (key !== 'token') {
          alert(`${key} = ${value}`);
      }
  });
}

checkUrlParams();

if (localStorage.getItem('estpremier') === null) {
  // Redirection vers test.php
  localStorage.setItem("estpremier","false");
  window.location.href = "./backend/config/test.php";
}

//fonction pour l'affichage des commentaires 

document.addEventListener("DOMContentLoaded", function () {
  const container = document.getElementById("zone-commentaires");
  const commentaires = JSON.parse(localStorage.getItem("commentaires")) || [];

  if (container && commentaires.length > 0) {
    commentaires.forEach(({ nom, texte, image, stars }) => {
      const div = document.createElement("div");
      div.className = "col-md-4 commentaire-card";
      div.innerHTML = `
        <div class="text-center">
          <img src="${image}" class="rounded-circle mb-2" width="60" height="60" alt="Photo utilisateur">
          <h5>${nom}</h5>
          <p class="text-muted">${texte}</p>
          <div class="stars">${"⭐".repeat(stars || 4)}${stars < 5 ? "☆".repeat(5 - stars) : ""}</div>
        </div>
      `;
      container.appendChild(div);
    });
  } else if (container) {
    container.innerHTML = "<p class='text-center text-muted'>Aucun commentaire pour le moment.</p>";
  }
});

