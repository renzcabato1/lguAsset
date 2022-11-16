@extends('layouts.header')
@section('content')
<div class="main-content">
    <section class="section">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
              @if(session()->has('status'))
                  <div class="alert alert-success alert-dismissable">
                      {{-- <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button> --}}
                      {{session()->get('status')}}
                  </div>
              @endif
              @include('error')
                <div class="card">
                    <div class="card-header">
                      <h4>Employee <a href="#" class="btn btn-icon btn-sm btn-success" title='New Employee' data-toggle="modal" data-target="#new_employee"><i class="fas fa-plus"></i></a></h4>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-hover " id="employees-table" style="width:100%;">
                          <thead>
                            <tr>
                              <th>Name</th>
                              <th>Emp Code</th>
                              <th>Department</th>
                              <th>Position</th>
                              <th>Emplooyee Type</th>
                              <th>Status</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($employees as $employee)
                                <tr>
                                    <td>{{$employee->name}}</td>
                                    <td>{{$employee->emp_code}}</td>
                                    <td>{{$employee->dep->name}}</td>
                                    <td>{{$employee->position}}</td>
                                    <td>{{$employee->emp_type}}</td>
                                    <td>{{$employee->status}}</td>
                                    <td>
                                      <a href="#" onclick='viewAccountabilities({{$employee->emp_code}});' title='View Accountabilities' class="btn btn-icon btn-primary" data-toggle="modal" data-target="#viewAccountability">
                                        <i class="far fa-eye">
                                        </i>
                                      </a>
                                    </td>
                                </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@include('new_employee');
{{-- @foreach($employees as $employee)
  @include('generateQrCode');
@endforeach --}}
@include('view_accountabilities');
<script type="text/template" id="qrcodeTpl">
  <div class="imgblock">
      
      <div class="qr" id="qrcode_{i}"></div>
      <div class="title">{title}</div>
  </div>
</script>
<script>
    var employeeInventories = {!! json_encode($employeeInventories->toArray()) !!};
    console.log(employeeInventories);
    function viewAccountabilities(Data)
    {
      $("#AccountabilitiesData" ).empty();
        var count = 0;
        for(var i=0;i<employeeInventories.length;i++)
        {
          if(Data == employeeInventories[i].emp_code)
          {
            
            count = count +1;
            var tableTd = "<tr>";
                tableTd += "<td>"+employeeInventories[i].inventory_data.category.code+"-"+pad("00000",employeeInventories[i].inventory_data.equipment_code,true)+"</td>";
                tableTd += "<td>"+employeeInventories[i].inventory_data.category.category_name+"</td>";
                tableTd += "<td>"+employeeInventories[i].inventory_data.brand+"</td>";
                tableTd += "<td>"+employeeInventories[i].inventory_data.model+"</td>";
                tableTd += "<td>"+employeeInventories[i].inventory_data.serial_number+"</td>";
                tableTd += "<td><small>"+nl2br (employeeInventories[i].inventory_data.description)+"</small></td>";
                tableTd += "<td>"+employeeInventories[i].status+"</td>";
                tableTd += "</tr>";

            $("#AccountabilitiesData" ).append(tableTd);
            console.log(employeeInventories[i].inventory_data);

          }
        }
        if(count == 0)
        {
            var tableTd = "<tr>";
                tableTd += "<td colspan='6' class='text-center'>--No Data Found--</td>";
                tableTd += "</tr>";
                $("#AccountabilitiesData" ).append(tableTd);
        }
       
       
    }
 

    function nl2br (str, is_xhtml) 
    {
      var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br ' + '/>' : '<br>';
      return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
    }
    function pad(pad, str, padLeft) 
    {
      if (typeof str === 'undefined') 
          return pad;
      if (padLeft) {
          return (pad + str).slice(-pad.length);
      } else {
          return (str + pad).substring(0, pad.length);
      }
    }
   
        
</script>
@endsection
@section('footer')
  <script src="{{ asset('assets/js/app.min.js') }}"></script>
@endsection