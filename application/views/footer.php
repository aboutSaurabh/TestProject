
</body>

<script>
$(document).ready(function () {
 // $('#dtBasicExample').DataTable();
//  $('.dataTables_length').addClass('bs-select');
});
setInterval(function(){
 ajaxRequest();
}, 7000);

function ajaxRequest(){
    console.log("hi____");
    var finalUrl = base_url+"/cron";
        $.ajax({
          url: finalUrl,
          type: "post",
          success: function(data) {
              var resp = JSON.parse(data);
              if(resp.status ==1){
                  var finalData =   resp.data !=''  ? resp.data:[];
                    var i;
                   // for (i = 0; i < finalData.length; i++) {
                        var  status =  finalData.status;
                        var id =  finalData.id;
                        if(status==1){
                            $(".status_"+id).html('<span class="badge badge-success">Completed</span>');
                        }else if(finalData.status==0){
                             $(".status_"+id).html('<span class="badge badge-warning">Pending</span>');
                        }
                      
                    //}
                   
              }
              console.log("response",id);
          }
      });
}
</script>