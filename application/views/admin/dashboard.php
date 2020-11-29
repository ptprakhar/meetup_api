<?php 
$this->load->view('admin/templates/header');
//$this->load->view('admin/templates/sidebar');
?>
<script type="text/javascript">
  $(document).ready(function() {
    $('#example').DataTable(
        
         {     

      "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
        "iDisplayLength": 5
       } 
        );
} );


function checkAll(bx) {
  var cbs = document.getElementsByTagName('input');
  for(var i=0; i < cbs.length; i++) {
    if(cbs[i].type == 'checkbox') {
      cbs[i].checked = bx.checked;
    }
  }
}
</script>

<div class="container">
  <div class="row">
  <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                
                <th>Name</th>
                <th>Age</th>
                <th>DOB</th>
                <th>Profession</th>
                <th>Locality</th>
                <th>No of guests</th>
                <th>Address</th>
            </tr>
        </thead>
        <tbody>
           
<?php
if(!empty($participantsData))
    foreach ($participantsData as $key => $value) {
      echo '<tr>
                <td>'.$value->name.'</td>
                <td>'.$value->age.'</td>
                <td>'.$value->dob.'</td>
                <td>'.$value->profession.'</td>
                <td>'.$value->locality.'</td>
                <td>'.$value->no_of_guests.'</td>
                <td>'.$value->address.'</td>

                
            </tr>';
    
}
?>
          
        </tbody>
  </div>
</div>
<?php
$this->load->view('admin/templates/footer');
?>