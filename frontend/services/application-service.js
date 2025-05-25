var ApplicationService = {
  getApplications: function () {
    const token = localStorage.getItem("user_token");

    return $.ajax({
      url: Constants.PROJECT_BASE_URL + 'applications',
      type: 'GET',
      headers: {
        'Authentication': token
      }
    });
  }
};
