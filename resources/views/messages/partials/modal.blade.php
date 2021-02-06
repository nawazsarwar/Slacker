<style>
    @media (min-width: 992px) {
        .modal-lg, .modal-xl {
            max-width: 90%;
        }
    }
</style>
<div  class="modal fade" id="slackerMessageModal" tabindex="-1" role="dialog" aria-labelledby="slackerMessageModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="width: 90%;" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="slackerMessageTitle">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div id="slackerMessageBody" class="modal-body">
            <dl class="row">
                <dt class="col-sm-3">Identifier</dt>
                <dd class="col-sm-9" ><span id="title"></span><br><small><a target="_blank" id="searchTitle" href="">Search on Google</a></small></dd>


                <dt class="col-sm-3">Level</dt>
                <dd class="col-sm-9" id="level"></dd>

                <dt class="col-sm-3">Time</dt>
                <dd class="col-sm-9" id="time"></dd>

                <dt class="col-sm-3">User Identification</dt>
                <dd class="col-sm-9" id="user_id"></dd>

                <dt class="col-sm-3">Breakpoint</dt>
                <dd class="col-sm-9" ><code id="main_cause"> </code></dd>

                <dt class="col-sm-3">Exception Type</dt>
                <dd class="col-sm-9" ><code id="exception_type"> </code></dd>

            </dl>
            <button class="btn btn-sm btn-secondary " id="showTraceButton">Show Stack Trace</button>
            <br><br>
            <div id="trace" style="display:none;">
                <table style="display: inline-table;" class="table table-responsive table-sm table-hover table-striped table-bordered">
                    <thead>
                        <th style="width: 100%;">File(s)</th>
                    </thead>
                    <tbody id="trace_body">
                    </tbody>
                  </table>
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
