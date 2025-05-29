let RestClient = {
    get: function (url, callback, error_callback) {
      $.ajax({
        url: Constants.PROJECT_BASE_URL + url,
        type: "GET",
        beforeSend: function (xhr) {
          xhr.setRequestHeader("Authentication", localStorage.getItem("user_token"));
        },
        success: callback,
        error: error_callback
      });
    },
    request: function (url, method, data, callback, error_callback) {
      $.ajax({
        url: Constants.PROJECT_BASE_URL + url,
        type: method,
        data: JSON.stringify(data),
        contentType: "application/json",
        beforeSend: function (xhr) {
          xhr.setRequestHeader("Authentication", localStorage.getItem("user_token"));
        }
      })
      .done(callback)
      .fail(function (jqXHR) {
        toastr.error(jqXHR?.responseJSON?.message || "Request failed.");
        if (error_callback) error_callback(jqXHR);
      });
    },
    post: function (url, data, cb, err) { RestClient.request(url, "POST", data, cb, err); },
    put: function (url, data, cb, err) { RestClient.request(url, "PUT", data, cb, err); },
    delete: function (url, data, cb, err) { RestClient.request(url, "DELETE", data, cb, err); },
    patch: function (url, data, cb, err) { RestClient.request(url, "PATCH", data, cb, err); }
  };
  