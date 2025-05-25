var UserService = {
    init: function () {
      let token = localStorage.getItem("user_token");
      if (token) {
        window.location.replace("index.html");
      }
  
      $("#login-form").validate({
        submitHandler: function (form) {
          let entity = Object.fromEntries(new FormData(form).entries());
          UserService.login(entity);
        }
      });

      $("#register-form").validate({
        submitHandler: function (form) {
          let entity = Object.fromEntries(new FormData(form).entries());
          UserService.register(entity);
        }
      });
    },

    register: function (entity) {
      $.ajax({
        url: Constants.PROJECT_BASE_URL + "auth/register",
        type: "POST",
        data: JSON.stringify(entity),
        contentType: "application/json",
        dataType: "json",
        success: function (result) {
          toastr.success("Registration successful! You can now log in.");
          window.location.replace("index.html"); // or "#login" if SPApp
        },
        error: function (xhr) {
          toastr.error(xhr.responseText || 'Registration failed');
        }
      });
    },
  
    login: function (entity) {
      $.ajax({
        url: Constants.PROJECT_BASE_URL + "auth/login",
        type: "POST",
        data: JSON.stringify(entity),
        contentType: "application/json",
        dataType: "json",
        success: function (result) {
          const role = result.data.role;
          console.log(role);
          localStorage.setItem("user_token", result.data.token);
          localStorage.setItem("user_role", role);
          UserService.generateNavbar();
          if (role === "admin") {
            window.location.href = "index.html#admin-dashboard"; // or scroll to section
          } else {
              window.location.href = "index.html#home-section"; // or scroll to home section
            }
        },
        error: function (xhr) {
          toastr.error(xhr.responseText || 'Login failed');
        }
      });
    },
  
    logout: function () {
      localStorage.clear();
      UserService.generateNavbar();
      window.location.href = "index.html#home-section";

    },

    generateNavbar: function () {
      const token = localStorage.getItem("user_token");
      const payload = Utils.parseJwt(token);
      const role = payload?.user?.role;

      let navHtml = '';
      let ctaHtml = `
        <div class="ml-auto">
          <a href="#home-section" class="btn btn-danger border-width-2 d-none d-lg-inline-block" onclick="UserService.logout()">
            <span class="mr-2 icon-lock_outline"></span>Logout
          </a>
        </div>
      `;

      if (role === 'job seeker') {
        navHtml = `
          <ul class="site-menu js-clone-nav d-none d-xl-block ml-0 pl-0">
            <li><a href="#home-section" class="nav-link">Home</a></li>
            <li><a href="#job-listings" class="nav-link">Browse Jobs</a></li>
            <li><a href="#saved-jobs" class="nav-link">Saved Jobs</a></li>
            <li><a href="#my-applications" class="nav-link">My Applications</a></li>
            <li><a href="#user-profile" class="nav-link">Profile</a></li>
          </ul>
        `;
      } else if (role === 'employer') {
        navHtml = `
          <ul class="site-menu js-clone-nav d-none d-xl-block ml-0 pl-0">
            <li><a href="#home-section" class="nav-link">Home</a></li>
            <li><a href="#post-job" class="nav-link">Post a Job</a></li>
            <li><a href="#my-jobs" class="nav-link">My Job Posts</a></li>
            <li><a href="#applicants" class="nav-link">Applicants</a></li>
            <li><a href="#company-profile" class="nav-link">Company Profile</a></li>
          </ul>
        `;
      } else if (role === 'admin') {
        navHtml = `
          <ul class="site-menu js-clone-nav d-none d-xl-block ml-0 pl-0">
            <li><a href="#admin-dashboard" class="nav-link">Dashboard</a></li>
            <li><a href="#admin-settings" class="nav-link">Settings</a></li>
          </ul>
        `;
      } else {
        navHtml = `
          <ul class="site-menu js-clone-nav d-none d-xl-block ml-0 pl-0">
            <li><a href="#home-section" class="nav-link">Home</a></li>
            <li><a href="#about" class="nav-link">About</a></li>
            <li><a href="#job-listings" class="nav-link">Job Listings</a></li>
            <li><a href="#contact" class="nav-link">Contact</a></li>
          </ul>  
        `;
        ctaHtml = `
          <div class="right-cta-menu text-right d-flex align-items-center col-6">
            <div class="ml-auto">
              <a href="#login" class="btn btn-primary border-width-2 d-none d-lg-inline-block">
                <span class="mr-2 icon-lock_outline"></span>Log In
              </a>
            </div>
            <a href="#" class="site-menu-toggle js-menu-toggle d-inline-block d-xl-none mt-lg-2 ml-3">
              <span class="icon-menu h3 m-0 p-0 mt-2"></span>
            </a>
          </div>
          `;
      }

      // Inject into DOM
      $('nav.site-navigation').html(navHtml);
      $('.right-cta-menu').html(ctaHtml);
    },
    getAllUsers: function () {
      const token = localStorage.getItem("user_token");

      if (!token) {
        console.error("No token found in localStorage.");
        return Promise.reject("No token found");
      }

      return $.ajax({
        url: 'http://localhost/web-project/backend/users',
        type: 'GET',
        headers: {
          "Authentication": token 
        },
        dataType: 'json'
      });
    },
    updateUser: function (id, userData) {
      const token = localStorage.getItem("user_token");

      return $.ajax({
        url: Constants.PROJECT_BASE_URL + 'users/' + id,
        type: 'PUT',
        headers: {
          'Authentication': token
        },
        contentType: 'application/json',
        data: JSON.stringify(userData),
        dataType: 'json'
      });
    },

    deleteUser: function (id) {
      const token = localStorage.getItem("user_token");

      return $.ajax({
        url: Constants.PROJECT_BASE_URL + 'users/' + id,
        type: 'DELETE',
        contentType: 'application/json', 
        headers: {
          'Authentication': token
        },
        dataType: 'json' 
      });
    },

    showAdminSection: function(){
      const token = localStorage.getItem("user_token");
      let role = null;

      try {
        if (token) {
          const payload = JSON.parse(atob(token.split('.')[1]));
          role = payload.role || payload.user?.role || localStorage.getItem("user_role");
        }
      } catch (e) {
        role = localStorage.getItem("user_role");
      }

      if (role !== "admin") {
        window.location.replace("index.html#login"); // or "#login" if SPApp
      }
    }










};
  