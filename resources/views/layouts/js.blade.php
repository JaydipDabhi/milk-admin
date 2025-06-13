<!-- jQuery (required for everything else) -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

<!-- Moment.js (required for daterangepicker and tempusdominus) -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>

<!-- Bootstrap Bundle (includes Popper.js, required for Bootstrap components like dropdowns, modals, tooltips) -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- InputMask (often used with date fields) -->
<script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>

<!-- Date Range Picker (depends on moment.js and Bootstrap) -->
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>

<!-- Tempusdominus Bootstrap 4 (depends on Bootstrap and Moment.js) -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>

<!-- Flatpickr (independent, but should be after jQuery and Bootstrap to avoid UI conflicts) -->
{{-- <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script> --}}

<!-- Bootstrap Color Picker (optional, sometimes used with date forms) -->
<script src="{{ asset('plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>

<!-- Bootstrap Switch (optional, UI component) -->
<script src="{{ asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>

<!-- jQuery Validate (form validation) -->
<script src="{{ asset('plugins/jquery/jquery.validate.min.js') }}"></script>

<!-- Select2 (UI plugin, sometimes used in forms) -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

<!-- Duallistbox (optional, for multiselect UI) -->
<script src="{{ asset('plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>

<!-- BS-Stepper (optional, for multi-step forms) -->
<script src="{{ asset('plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>

<!-- Dropzone (for file uploads, not directly related to date picker) -->
<script src="{{ asset('plugins/dropzone/min/dropzone.min.js') }}"></script>

<!-- DataTables (unrelated to date picker, but UI table support) -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<!-- AdminLTE core and demo scripts -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
<script src="{{ asset('dist/js/demo.js') }}"></script>
<script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
<script src="{{ asset('dist/js/pages/dashboard3.js') }}"></script>

<!-- Chart.js (for charts, not related to date picker) -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>

<!-- Custom JavaScript (should load after plugins) -->
<script src="{{ asset('dist/js/custom.js') }}"></script>

<!-- SweetAlert2 (must be loaded after jQuery) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
