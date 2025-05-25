let JobService = {

  getAllJobs: function() {
    return $.ajax({
      url: '/web-project/backend/jobs',
      method: 'GET',
      dataType: 'json'
    });
  },

  getPaginated: function (page = 1, limit = 7) {
    return $.ajax({
      url: `/web-project/backend/jobs?page=${page}&limit=${limit}`,
      method: 'GET',
      dataType: 'json'
    });
  },

  loadJobs: function (page = 1, limit = 7) {
    this.getPaginated(page, limit).then(response => {
      this.renderJobs(response.jobs);
      this.renderPagination(response.totalPages, page);
      this.updateShowingText(page, limit, response.totalCount);
    });
  },

  renderJobs: function (jobs) {
    let html = '';
    jobs.forEach(job => {
      html += `
        <li class="job-listing d-block d-sm-flex pb-3 pb-sm-0 align-items-center">
          <a href="#job-single?id=${job.job_id}"></a>
          <div class="job-listing-position custom-width w-100 mb-3 mb-sm-0">
            <h2>${job.title}</h2>
            <strong>${job.location}</strong>
          </div>
          <div class="job-listing-meta">
            <span class="badge badge-primary">${job.job_type}</span>
          </div>
        </li>`;
    });
    $('#job-list-container').html(html);
  },

  renderPagination: function (totalPages, currentPage) {
    let html = '';
    for (let i = 1; i <= totalPages; i++) {
      html += `<a href="#" class="${i === currentPage ? 'active' : ''}" data-page="${i}">${i}</a>`;
    }

    $('.custom-pagination .d-inline-block').html(html);

    $('.custom-pagination .prev').off().click(function (e) {
      e.preventDefault();
      if (currentPage > 1) JobService.loadJobs(currentPage - 1);
    });

    $('.custom-pagination .next').off().click(function (e) {
      e.preventDefault();
      if (currentPage < totalPages) JobService.loadJobs(currentPage + 1);
    });

    $('.custom-pagination .d-inline-block a').off().click(function (e) {
      e.preventDefault();
      const page = parseInt($(this).data('page'));
      JobService.loadJobs(page);
    });
  },

  updateShowingText: function (page, limit, total) {
    const start = (page - 1) * limit + 1;
    const end = Math.min(page * limit, total);
    $('.pagination-wrap span').text(`Showing ${start}-${end} of ${total} Jobs`);
  }

};

