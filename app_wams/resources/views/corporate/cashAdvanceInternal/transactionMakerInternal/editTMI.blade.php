<form action="{{route('update-TM-INTERNAL',$item->id)}}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="mb-2 row">
        <label  class="col-sm-2 col-form-label" style="font-size: 12px">Client</label>
        <div class="col-sm-10">
            <div class="form-control">{{ $data_project_internal->nama_client }}</div>
        </div>
    </div> 
    
    <div class="mb-2 row">
        <input type="hidden" id="client_val" value="{{ $data_project_internal->nama_client }}">
        <input type="hidden" name="cpt_id" id="cpt_id">
        <label  class="col-sm-2 col-form-label" style="font-size: 12px">Client Name</label>
        <div class="col-sm-10">
            <select class="form-control select2" id="client" style="width: 100%" required>
                <option value="" readonly>------PILIH------</option>
                @foreach($in_client as $key => $val)
                    <option value="{{ $val }}" data-id="{{$key}}">
                        {{ $val }}
                    </option>
                @endforeach
            </select>
        </div>
    </div> 

    <div class="mb-2 row">
        <label  class="col-sm-2 col-form-label" style="font-size: 12px">Project Name</label>
        <div class="col-sm-10">
            <select name="project_name" class="form-control select2" id="project" style="width: 100%" required disabled></select>
        </div>
    </div> 

    <div class="mb-2 row">
        <label  class="col-sm-2 col-form-label" style="font-size: 12px">ID Project</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="id_project" id="id_project" value="{{ $data_project_internal->id_project }}" readonly required>
        </div>
    </div> 

    
    <div class="modal-footer">
        <button type="submit" class="btn btn-sm btn-info" >Submit</button>
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
        <i class="bx bx-x d-block d-sm-none"></i>
        <span class="d-none d-sm-block">Close</span>
        </button>
    </div>
</form>

<script>
    $(".select2").select2();
    $("#client").on('select2:select', function () {
        $("#project").prop("disabled", false)
        var data = $("#client").val();
        $.ajax({
            url: "/getProjectByClientInternal",
            type: "POST",
            dataType: 'json',
            data: {
                client: data,
                _token: $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (r) {
                var element = '';
                console.log(r);
                for (var i = 0; i < r.length; i++) {
                    if (r.length == 1) {
                        element += '<option value="' + r[i].nama_project + '" selected>' + r[i].nama_project + '</option>';
                    } else {
                        element += '<option value="' + r[i].nama_project + '">' + r[i].nama_project + '</option>';
                    }
                }

                $('#project').html(element).trigger('change').select2('open');
            }
        })
    });

    // $("#project").change(function() {
    //     var selectedText = $(this).find("option:selected").text();
    //     $("#id_project").val(selectedText)
    // })

    $("#client").change(function() {
        var selectedText = $(this).find("option:selected").attr("data-id");
        $("#cpt_id").val(selectedText)
    })
    // $("#client").select2().val($("#client_val")).trigger("change");
    
</script>