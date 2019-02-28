
@include('joesama/project::vuegrid.datagrid', ['tableId' => data_get($data,'tableId')])

@push('datagrid')


<script type="text/javascript">
	Vue.config.devtools = "{{ config('vuegrid.debug',false) }}";
</script>


<script type="text/javascript">
	var app = @json($data);
</script>

<script type="text/javascript" src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
<script src="{{ asset('packages/joesama/vuegrid/js/datagrid.js') }}"></script>

@endpush
