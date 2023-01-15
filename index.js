function scrollTop() {
  const scrollUp = document.querySelector(".go-up");

  if (scrollUp) {
    scrollUp.addEventListener("click", () => {
      document.querySelector(".main").scroll({
        top: 0,
        behavior: "smooth",
      });
    });
  }
}

function toggleNav() {
  const toggleNav = document.querySelector(".show-nav");
  const closeNav = document.querySelector(".close-nav");
  const nav = document.querySelector("nav");
  const main = document.querySelector(".main");

  const media = window.matchMedia("(max-width: 1080px)");

  let isNavOpened = false;


  if (media.matches) {
    toggleNav.addEventListener("click", () => {
      if (!isNavOpened)
        isNavOpened = !isNavOpened;

        nav.classList.add("visible");
        main.classList.add("disabled");
    });

    closeNav.addEventListener("click", (e) => {
      if (isNavOpened)

        isNavOpened = !isNavOpened;

        nav.classList.remove("visible");
        main.classList.remove("disabled");
        
        // document.querySelector(".main").addEventListener('click', () => { console.log("clicked"); })
    });
      
    document.addEventListener('click', (e) => {
      if (!e.target.closest('.nav') && !e.target.closest('.main') && nav.classList.contains('visible')) {
        nav.classList.remove("visible");
        main.classList.remove("disabled");
      };
    })
  }
}

function showModal(modal_idx) {
  const modal = document.querySelector('.modal');

  if (modal && modal_idx) {
    const nav = document.querySelector("nav");
    const main = document.querySelector(".main");
    // ---
    const accept = document.querySelector('.accept')
    const decline = document.querySelector('.decline')
    // ---
    const deleteProfile = document.querySelector('.delete-profile');
    const displayNotifications = document.querySelector('.show-notifications');

    function display() {
      main.classList.add('disabled');
      nav.classList.add('disabled');
      modal.classList.remove('modal-hidden');
    }

    function displaySimple() {
      modal.classList.remove('modal-hidden');
    }
    
    function hide() {
      main.classList.remove('disabled');
      nav.classList.remove('disabled');
      modal.classList.add('modal-hidden');
    }

    if (modal_idx === 'delete') {
      console.log("works");
      display();

      accept.addEventListener('click', () => {
        hide();
        console.log('accepted');
      });

      decline.addEventListener('click', () => {
        hide();
        console.log('declined');
      });
    }

    if (modal_idx === 'show-notifications') {
     modal.classList.toggle('modal-hidden')
    }
  }
}

document.addEventListener('DOMContentLoaded', () => {
  const showNotifications = document.querySelector('.show-notifications');

  showNotifications.addEventListener('click', () => {
    console.log("clicked");
    showModal('show-notifications');
  })  

  if (document.querySelector('.delete-acc')) {
    document.querySelector('.delete-profile').addEventListener('click', () => {
      
      showModal('delete');
    })
  }

  showModal();
  toggleNav();
  scrollTop();

  // exportRaports();
});




