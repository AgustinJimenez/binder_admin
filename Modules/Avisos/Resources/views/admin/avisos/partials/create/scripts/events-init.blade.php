<script type="text/javascript">
	$(document).ready(function()
	{
		$(document).keypressAction({actions: [{ key: 'b', route: "{{ route('admin.avisos.aviso.index') }}" }]});
		$('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });
	});
</script>