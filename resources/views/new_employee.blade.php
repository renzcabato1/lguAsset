
<div class="modal" id="new_employee" tabindex="-1" role="dialog"  >
    <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class='col-md-10'>
                    <h5 class="modal-title" id="exampleModalLabel">New Employee</h5>
                </div>
                <div class='col-md-2'>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <form method='post' action='new-employee' onsubmit='show();'  enctype="multipart/form-data" >
                <div class="modal-body">
                    {{ csrf_field() }}
                    <div class='col-md-12'>
                        Name :
                        <input type="text" class="form-control-sm form-control "  value="{{ old('name') }}"  name="name" required/>
                    </div>
                    <div class='col-md-12'>
                        Employee Code :
                        <input type="text" class="form-control-sm form-control "  value="{{ old('employee_code') }}"  name="employee_code" required/>
                    </div>
                    <div class='col-md-12'>
                        Department :

                        <select id='department_select' class='form-control select2 form-control-sm' name='department' style='width:100%' required >
                            <option value=''></option>
                            @foreach($departments as $department)
                            <option value='{{$department->code}}'>{{$department->name}} - {{$department->code}}</option>
                            @endforeach
                            </select>
                       
                    </div>
                 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type='submit'  class="btn btn-primary" >Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>