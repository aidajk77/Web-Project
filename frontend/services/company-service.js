let CompanyService = {
    

  getAllCompanies: function() {
    const token = localStorage.getItem("user_token");
    return $.ajax({
      url: Constants.PROJECT_BASE_URL + 'companies',
      type: 'GET',
      headers: {
        'Authentication': token
      }
    });
  
}
}