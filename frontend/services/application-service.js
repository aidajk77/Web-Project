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
  },
  updateApplication: function (id, applicationData) {
    const token = localStorage.getItem("user_token");
    return $.ajax({
      url: Constants.PROJECT_BASE_URL + 'applications/' + id,
      method: 'PUT',
      contentType: 'application/json',
      data: JSON.stringify(applicationData),
      headers: {
          'Authentication': token
      },
      dataType: 'json'
    })}
};
