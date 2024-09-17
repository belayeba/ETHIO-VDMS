<link href="{{ asset('assets/css/redmond.calendars.picker.css') }}" rel="stylesheet"/>
  <!-- jQuery  -->
        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.plugin.js') }}"></script> 
        <script src="{{ asset('assets/js/jquery.calendars.js') }}"></script> 
        <script src="{{ asset('assets/js/jquery.calendars.plus.js') }}"></script> 
        <script src="{{ asset('assets/js/jquery.calendars.picker.js') }}"></script> 
        <script src="{{ asset('assets/js/jquery.calendars.ethiopian.js') }}"></script> 
        <script src="{{ asset('assets/js/jquery.calendars.ethiopian-am.js') }}"></script>

        <div class="col-lg-3">
        <div class="mb-4">
            <label class="form-label" for="date"><h5 style="color:#215467; font-weight: bold; font-family:serif;">የችሎት ቀን</h5></label>
            <input type="text" placeholder="ዓ.ም/ወር/ቀን" class="form-control rounded" name="date" id="date" required="" title="ቀን ያስገቡ">
        </div>
                <script> 
        $('#date').calendarsPicker({ 
            calendar: $.calendars.instance('ethiopian', 'am'), 
            pickerClass: 'myPicker', 
            dateFormat: 'yyyy-mm-dd' 
        });
            </script>
        </div>