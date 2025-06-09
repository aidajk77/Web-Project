
// Get the navigation container
var navContainer = document.querySelector(".site-navbar");

// Get all navigation links inside the container
var navLinks = navContainer.getElementsByClassName("nav-link");

// Function to update active class
function updateActiveNav(event) {
    // Remove "active" from any currently active link
    var current = document.getElementsByClassName("active");
    if (current.length > 0) {
        current[0].classList.remove("active");
    }

    // If event exists (clicked), set the clicked link as active
    if (event) {
        this.classList.add("active");
    } else {
        // If triggered by URL hash change, set the correct link as active
        var currentHash = window.location.hash || "#home"; // Default to home
        var activeLink = document.querySelector('.site-menu .nav-link[href="' + currentHash + '"]');
        if (activeLink) {
            activeLink.classList.add("active");
        }
		if (currentHash === "#job-single" || currentHash === "#post-job") {
			var jobListingsLink = document.querySelector('.site-menu .nav-link[href="#job-listings"]');
			if (jobListingsLink) {
				jobListingsLink.classList.add("active"); // Keep only "Job Listings" active
			}
		}
    }
}

// Loop through each navigation link and add event listener
for (var i = 0; i < navLinks.length; i++) {
    navLinks[i].addEventListener("click", updateActiveNav);
}

// Listen for URL hash changes (SPApp navigation updates)
window.addEventListener("hashchange", function() {
    updateActiveNav();
});

// Initialize on page load
updateActiveNav();

$(document).on('click', '#openApplicationsBtn', function (e) {
  e.preventDefault();

  $('#applicationsModal').modal('show');
  $('#applications-container').html('<p>Loading applications...</p>');

  ApplicationService.getApplications()
    .then(response => {
      let html = '';
      if (response.length > 0) {
        html += `
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>ID</th>
                <th>Applicant ID</th>
                <th>Applicant name</th>
                <th>Job ID</th>
                <th>Job title</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
        `;

        response.forEach(app => {
          html += `
            <tr>
              <td>${app.id}</td>
              <td>${app.user_id || '-'}</td>
              <td>${app.user_name}</td>
              <td>${app.job_id}</td>
              <td>${app.job_title}</td>
              <td>${app.status}</td>
              <td>
                <button class="btn btn-sm btn-primary me-1 edit-app-btn" data-id="${app.id}">Edit</button>
                <button class="btn btn-sm btn-danger me-1 delete-app-btn" data-id="${app.id}">Delete</button>
                <button class="btn btn-sm btn-secondary view-app-btn" data-id="${app.id}">View</button>
              </td>
            </tr>
          `;
        });

        html += `</tbody></table>`;
      } else {
        html = '<p>No applications found.</p>';
      }

      $('#applications-container').html(html);
    })
    .catch(() => {
      $('#applications-container').html('<p class="text-danger">Failed to load applications.</p>');
    });
});

// DELETE application
$(document).on('click', '.delete-app-btn', function () {
  const appId = $(this).data('id');

  if (confirm("Are you sure you want to delete this application?")) {
    ApplicationService.deleteApplication(appId)
      .then(() => {
        toastr.success("Application deleted successfully.");
        $(`#application-${appId}`).remove(); // assuming row has id="application-1"
      })
      .catch(() => {
        toastr.error("Failed to delete application.");
      });
  }
});

// VIEW application (can be extended)
$(document).on('click', '.view-app-btn', function () {
  const id = $(this).data('id');
  alert('View application ID: ' + id);
  // You can load details into a separate modal or UI section
});

// EDIT application - fill modal
$(document).on('click', '.edit-app-btn', function () {
  const appId = $(this).data('id');

  ApplicationService.getApplications().then(apps => {
    const app = apps.find(a => a.id === appId); 
    if (!app) return;

    $('#edit-app-id').val(app.id);
    $('#edit-app-status').val(app.status || 'pending');
    

    $('#editApplicationModal').modal('show');
  });
});

// SUBMIT updated application
$(document).on('submit', '#editApplicationForm', function (e) {
  e.preventDefault();

  const id = $('#edit-app-id').val();
  console.log("Editing app ID:", id); // This must print a number
  const updatedApp = {
    status: $('#edit-app-status').val()
  };

  ApplicationService.updateApplication(id, updatedApp)
    .then(() => {
      toastr.success("Application updated successfully");
      $('#editApplicationModal').modal('hide');
      $('#openApplicationsBtn').click(); // Refresh the list if needed
    })
    .catch(xhr => {
      toastr.error(xhr.responseText || "Update failed");
    });
});




$(document).on('click', '#openUsersBtn', function (e) {
  e.preventDefault();

  $('#userListModal').modal('show');
  $('#users-container').html('<p>Loading users...</p>');

  UserService.getAllUsers()
    .then(response => {
      let html = '';
      if (response.length > 0) {
        html += `
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
        `;

        response.forEach(user => {
          html += `
            <tr>
              <td>${user.id}</td>
              <td>${user.name || '-'}</td>
              <td>${user.email}</td>
              <td>${user.role}</td>
              <td>
                <button class="btn btn-sm btn-primary me-1 edit-user-btn" data-id="${user.id}">Edit</button>
                <button class="btn btn-sm btn-danger me-1 delete-user-btn" data-id="${user.id}">Delete</button>
                <button class="btn btn-sm btn-secondary view-user-btn" data-id="${user.id}">View</button>
              </td>
            </tr>
          `;
        });

        html += `</tbody></table>`;
      } else {
        html = '<p>No users found.</p>';
      }

      $('#users-container').html(html);
    })
    .catch(() => {
      $('#users-container').html('<p class="text-danger">Failed to load users.</p>');
    });
});

$(document).on('click', '.delete-user-btn', function () {
  const userId = $(this).data('id');

  if (confirm("Are you sure you want to delete this user?")) {
    UserService.deleteUser(userId)
      .then(() => {
        toastr.success("User deleted successfully.");
        // Refresh or remove from DOM
        $(`#user-${userId}`).remove();
      })
      .catch(() => {
        toastr.error("Failed to delete user.");
      });
  }
});

$(document).on('click', '.view-user-btn', function () {
  const id = $(this).data('id');
  alert('View user ID: ' + id);
  // Add logic to show details
});

$(document).on('click', '.edit-user-btn', function () {
  const userId = $(this).data('id');

  // Fetch user by ID from your user list (or via API)
  UserService.getAllUsers().then(users => {
    const user = users.find(u => u.id === userId);
    if (!user) {
		return;
	}

    $('#edit-user-id').val(user.id);
    $('#edit-user-name').val(user.name || '');
    $('#edit-user-email').val(user.email || '');
    $('#edit-user-role').val(user.role || 'job seeker');

    $('#editUserModal').modal('show');
  });
});

$(document).on('submit', '#editUserForm', function (e) {
  e.preventDefault();

  const id = $('#edit-user-id').val();
  const updatedUser = {
    name: $('#edit-user-name').val(),
    email: $('#edit-user-email').val(),
    role: $('#edit-user-role').val()
  };
  UserService.updateUser(id, updatedUser)
    .then(response => {
	  console.log("edit enter")
      toastr.success("User updated successfully");
      $('#editUserModal').modal('hide');
      $('#openUsersBtn').click(); // Refresh the list
    })
    .catch(xhr => {
      toastr.error(xhr.responseText || "Update failed");
    });
});

$(document).on('click', '#openJobsBtn', function (e) {
  e.preventDefault();

  $('#jobListModal').modal('show');
  $('#jobs-container').html('<p>Loading jobs...</p>');

  JobService.getAllJobs()
    .then(response => {
      let html = '';
      if (response.length > 0) {
        html += '<ul class="list-group">';
        response.forEach(job => {
          html += `
            <li class="list-group-item">
              <strong>${job.title}</strong><br>
              <small>${job.location} • ${job.job_type}</small>
              <div class="mt-2">
                <button class="btn btn-sm btn-info me-2 view-job-btn" data-id="${job.id}">View</button>
                <button class="btn btn-sm btn-warning me-2 edit-job-btn" data-id="${job.id}">Edit</button>
                <button class="btn btn-sm btn-danger delete-job-btn" data-id="${job.id}">Delete</button>
              </div>
            </li>
          `;
        });
        html += '</ul>';
      } else {
        html = '<p>No job listings found.</p>';
      }

      $('#jobs-container').html(html);
    })
    .catch(() => {
      $('#jobs-container').html('<p class="text-danger">Failed to load jobs.</p>');
    });
});

// DELETE job
$(document).on('click', '.delete-job-btn', function () {
  const jobId = $(this).data('id');

  if (confirm("Are you sure you want to delete this job?")) {
    JobService.deleteJob(jobId)
      .then(() => {
        toastr.success("Job deleted successfully.");
        $(`#job-${jobId}`).remove(); // Remove from DOM if using row ID
      })
      .catch(() => {
        toastr.error("Failed to delete job.");
      });
  }
});

// VIEW job
$(document).on('click', '.view-job-btn', function () {
  const id = $(this).data('id');
  alert('View job ID: ' + id);
  // Extend here to open a modal or page with full job details
});

// EDIT job
$(document).on('click', '.edit-job-btn', function () {
  const jobId = $(this).data('id');

  JobService.getAllJobs().then(jobs => {
    const job = jobs.find(j => j.id === jobId);
    if (!job) return;

    $('#edit-job-id').val(job.id);
    $('#edit-job-title').val(job.title || '');
    $('#edit-job-company').val(job.company || '');
    $('#edit-job-location').val(job.location || '');
    $('#edit-job-status').val(job.status || 'pending');
    $('#edit-job-description').val(job.description || '');

    populateCompanyDropdown(job.id);
    

    $('#editJobModal').modal('show');
  });
});

// SUBMIT updated job
$(document).on('submit', '#editJobForm', function (e) {
  e.preventDefault();

  const id = $('#edit-job-id').val();
  const updatedJob = {
    title: $('#edit-job-title').val(),
    company_id: $('#edit-job-company').val(),
    location: $('#edit-job-location').val(),
    status: $('#edit-job-status').val(),
    description: $('#edit-job-description').val()
  };
  console.log("Updated job data:", updatedJob);

  JobService.updateJob(id, updatedJob)
    .then(() => {
      toastr.success("Job updated successfully");
      $('#editJobModal').modal('hide');
      $('#openJobsBtn').click(); // Refresh list
    })
    .catch(xhr => {
      toastr.error(xhr.responseText || "Update failed");
    });
});

function populateCompanyDropdown(selectedCompanyId) {
  CompanyService.getAllCompanies().then(companies => {
    const $dropdown = $('#edit-job-company');
    $dropdown.empty();

    companies.forEach(company => {
      $dropdown.append(`<option value="${company.id}" ${company.id === selectedCompanyId ? 'selected' : ''}>${company.name}</option>`);
    });
  });
}








$(document).ready(function() {
    var app = $.spapp({
        defaultView  : "#home-section",
        templateDir  : "pages/",
        pageNotFound : "#error_404"
    });

    // LOGIN
    app.route({
        view: "login",
        load: "login.html",
        onCreate: function() {
            UserService.init();
            UserService.generateNavbar(); // ✅ add here
        }
    });

    // HOME
    app.route({
        view: "home-section",
        onCreate: function () {
            JobService.loadJobs();
            UserService.generateNavbar(); // ✅ add here too
        }
    });

    // JOB LISTINGS
    app.route({
        view: "job-listings",
        onCreate: function() {
            JobService.loadJobs();
            UserService.generateNavbar();
        }
    });

    app.route({
      view: "admin-dashboard",
      onCreate: function () {
        UserService.generateNavbar();
        UserService.showAdminSection(); // ✅ only here
      }
    });

    app.route({
      view: "admin-settings",
      onCreate: function () {
        UserService.generateNavbar();
        UserService.showAdminSection(); // ✅ only here
      }
    });

    // DEFAULT navbar update
    UserService.generateNavbar();

    app.run();
});



$(document).ready(function() {
    // Scroll to top button click event
    $("#scroll-top").click(function() {
        $("html, body").animate({ scrollTop: 0 }, 600); // 600ms smooth scroll
    });
});

jQuery(function($) {

	'use strict';
	
	$(".loader").delay(1000).fadeOut("slow");
  $("#overlayer").delay(1000).fadeOut("slow");	

	var siteMenuClone = function() {

		$('.js-clone-nav').each(function() {
			var $this = $(this);
			$this.clone().attr('class', 'site-nav-wrap').appendTo('.site-mobile-menu-body');
		});


		setTimeout(function() {
			
			var counter = 0;
      $('.site-mobile-menu .has-children').each(function(){
        var $this = $(this);
        
        $this.prepend('<span class="arrow-collapse collapsed">');

        $this.find('.arrow-collapse').attr({
          'data-toggle' : 'collapse',
          'data-target' : '#collapseItem' + counter,
        });

        $this.find('> ul').attr({
          'class' : 'collapse',
          'id' : 'collapseItem' + counter,
        });

        counter++;

      });

    }, 1000);

		$('body').on('click', '.arrow-collapse', function(e) {
      var $this = $(this);
      if ( $this.closest('li').find('.collapse').hasClass('show') ) {
        $this.removeClass('active');
      } else {
        $this.addClass('active');
      }
      e.preventDefault();  
      
    });

		$(window).resize(function() {
			var $this = $(this),
				w = $this.width();

			if ( w > 768 ) {
				if ( $('body').hasClass('offcanvas-menu') ) {
					$('body').removeClass('offcanvas-menu');
				}
			}
		})

		$('body').on('click', '.js-menu-toggle', function(e) {
			var $this = $(this);
			e.preventDefault();

			if ( $('body').hasClass('offcanvas-menu') ) {
				$('body').removeClass('offcanvas-menu');
				$this.removeClass('active');
			} else {
				$('body').addClass('offcanvas-menu');
				$this.addClass('active');
			}
		}) 

		// click outisde offcanvas
		$(document).mouseup(function(e) {
	    var container = $(".site-mobile-menu");
	    if (!container.is(e.target) && container.has(e.target).length === 0) {
	      if ( $('body').hasClass('offcanvas-menu') ) {
					$('body').removeClass('offcanvas-menu');
				}
	    }
		});
	}; 
	siteMenuClone();


	var sitePlusMinus = function() {
		$('.js-btn-minus').on('click', function(e){
			e.preventDefault();
			if ( $(this).closest('.input-group').find('.form-control').val() != 0  ) {
				$(this).closest('.input-group').find('.form-control').val(parseInt($(this).closest('.input-group').find('.form-control').val()) - 1);
			} else {
				$(this).closest('.input-group').find('.form-control').val(parseInt(0));
			}
		});
		$('.js-btn-plus').on('click', function(e){
			e.preventDefault();
			$(this).closest('.input-group').find('.form-control').val(parseInt($(this).closest('.input-group').find('.form-control').val()) + 1);
		});
	};
	// sitePlusMinus();

   var siteIstotope = function() {
  	/* activate jquery isotope */
	  var $container = $('#posts').isotope({
	    itemSelector : '.item',
	    isFitWidth: true
	  });

	  $(window).resize(function(){
	    $container.isotope({
	      columnWidth: '.col-sm-3'
	    });
	  });
	  
	  $container.isotope({ filter: '*' });

	    // filter items on button click
	  $('#filters').on( 'click', 'button', function(e) {
	  	e.preventDefault();
	    var filterValue = $(this).attr('data-filter');
	    $container.isotope({ filter: filterValue });
	    $('#filters button').removeClass('active');
	    $(this).addClass('active');
	  });
  }

  siteIstotope();

  var fancyBoxInit = function() {
	  $('.fancybox').on('click', function() {
		  var visibleLinks = $('.fancybox');

		  $.fancybox.open( visibleLinks, {}, visibleLinks.index( this ) );

		  return false;
		});
	}
	fancyBoxInit();


	var stickyFillInit = function() {
		$(window).on('resize orientationchange', function() {
	    recalc();
	  }).resize();

	  function recalc() {
	  	if ( $('.jm-sticky-top').length > 0 ) {
		    var elements = $('.jm-sticky-top');
		    Stickyfill.add(elements);
	    }
	  }
	}
	stickyFillInit();


	// navigation
  var OnePageNavigation = function() {
    var navToggler = $('.site-menu-toggle');
   	$("body").on("click", ".main-menu li a[href^='#'], .smoothscroll[href^='#'], .site-mobile-menu .site-nav-wrap li a", function(e) {
      e.preventDefault();

      var hash = this.hash;

      $('html, body').animate({
        'scrollTop': $(hash).offset().top
      }, 600, 'easeInOutCirc', function(){
        window.location.hash = hash;
      });

    });
  };
  OnePageNavigation();

  var counterInit = function() {
		if ( $('.section-counter').length > 0 ) {
			$('.section-counter').waypoint( function( direction ) {

				if( direction === 'down' && !$(this.element).hasClass('ftco-animated') ) {

					var comma_separator_number_step = $.animateNumber.numberStepFactories.separator(',')
					$('.number').each(function(){
						var $this = $(this),
							num = $this.data('number');
							console.log(num);
						$this.animateNumber(
						  {
						    number: num,
						    numberStep: comma_separator_number_step
						  }, 7000
						);
					});
					
				}

			} , { offset: '95%' } );
		}

	}
	counterInit();

	var selectPickerInit = function() {
		$('.selectpicker').selectpicker();
	}
	selectPickerInit();

	var owlCarouselFunction = function() {
		$('.single-carousel').owlCarousel({
	    loop:true,
	    margin:0,
	    nav:true,
	    autoplay: true,
	    items:1,
	    nav: false,
	    smartSpeed: 1000
		});

	}
	owlCarouselFunction();
	

	var quillInit = function() {

		var toolbarOptions = [
		  ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
		  ['blockquote', 'code-block'],

		  [{ 'header': 1 }, { 'header': 2 }],               // custom button values
		  [{ 'list': 'ordered'}, { 'list': 'bullet' }],
		  [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
		  [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
		  [{ 'direction': 'rtl' }],                         // text direction

		  [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
		  [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

		  [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
		  [{ 'font': [] }],
		  [{ 'align': [] }],

		  ['clean']                                         // remove formatting button
		];
		

		if ( $('.editor').length > 0 ) {
			var quill = new Quill('#editor-1', {
			  modules: {
			    toolbar: toolbarOptions,
			  },
			  placeholder: 'Compose an epic...',
			  theme: 'snow'  // or 'bubble'
			});
			var quill = new Quill('#editor-2', {
			  modules: {
			    toolbar: toolbarOptions,
			  },
			  placeholder: 'Compose an epic...',
			  theme: 'snow'  // or 'bubble'
			});
		}

	}
	quillInit();
	
  
});