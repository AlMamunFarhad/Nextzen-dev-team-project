$(document).ready(function(){
    // Mobile Menu Icon
   $('#nav-icon').click(function(){
      $(this).toggleClass('open');
      $('.header-nav nav').slideToggle();
   });


   // niceSelect
   // $('select').niceSelect();

    $('select.nice-select').niceSelect();

});




// step js 
  const steps = document.querySelectorAll('.step');
  const contents = document.querySelectorAll('.step-content');
  const progressBar = document.querySelector('.steps-progress');
  const nextBtn = document.getElementById('nextBtn');

  const consultBoxes = document.querySelectorAll('.consult-box');



  let currentStep = 0;

  function showStep(index) {
    steps.forEach((step, i) => {
      step.classList.toggle('active', i === index);
    });

    contents.forEach((content, i) => {
      content.classList.toggle('active', i === index);
    });

    // --- PROGRESS CALCULATION ---
    const wrapper = document.querySelector('.steps-wrapper');
    const totalSteps = steps.length - 1;

    const lineWidth = wrapper.offsetWidth - 80; // 40px left + 40px right
    const progress = (index / totalSteps) * lineWidth;

    progressBar.style.width = `${progress}px`;

    // Button text
    nextBtn.textContent =
      index === totalSteps ? 'Confirm' : 'Continue';
  }



  nextBtn.addEventListener('click', () => {
    if (currentStep < steps.length - 1) {
      currentStep++;
      showStep(currentStep);
    }
  });

  steps.forEach(step => {
    step.addEventListener('click', () => {
      currentStep = Number(step.dataset.step);
      showStep(currentStep);
    });
  });

  showStep(currentStep);



  consultBoxes.forEach(box => {
    box.addEventListener('click', () => {
        consultBoxes.forEach(b => b.classList.remove('active'));
        box.classList.add('active');
    });
  });




// JavaScript (generate next 5 days + selectable)

  const dateContainer = document.getElementById('dateContainer');
    const daysToShow = 5;

    const today = new Date();

    function formatDate(date) {
    return date.toLocaleDateString('en-GB', {
        day: 'numeric',
        month: 'short'
    });
    }

    function formatDayLabel(date, index) {
    if (index === 0) return 'Today';
    if (index === 1) return 'Tomorrow';
    return date.toLocaleDateString('en-US', { weekday: 'short' });
    }

    // Generate date boxes
    for (let i = 0; i < daysToShow; i++) {
    const date = new Date();
    date.setDate(today.getDate() + i);

    const box = document.createElement('div');
    box.className = 'date-box' + (i === 0 ? ' active' : '');
    box.dataset.date = date.toISOString().split('T')[0];

    box.innerHTML = `
        <span class="gray">${formatDayLabel(date, i)}</span><br>
        <strong>${formatDate(date)}</strong><br>
        <span class="green">${Math.floor(Math.random() * 10 + 5)} slots</span>
    `;

    dateContainer.appendChild(box);
    }

    // Click handling (single selection)
    const dateBoxes = document.querySelectorAll('.date-box');

    dateBoxes.forEach(box => {
    box.addEventListener('click', () => {
        dateBoxes.forEach(b => b.classList.remove('active'));
        box.classList.add('active');

        // Selected date value
        console.log('Selected date:', box.dataset.date);
    });
    });
