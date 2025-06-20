export const tinymceConfig = {
    base_url: '/assets/tinymce/js',
    height: 400,
    menubar: true,
    plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table paste code help wordcount'
    ],
    toolbar: 'undo redo | formatselect | bold italic backcolor | \
        alignleft aligncenter alignright alignjustify | \
        bullist numlist outdent indent | removeformat | help | code',
    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
    formats: {
        alertwarning: { block: 'div', classes: 'alert-warning', wrapper: true },
        alertinfo: { block: 'div', classes: 'alert-info', wrapper: true },
        alertdanger: { block: 'div', classes: 'alert-danger', wrapper: true },
        alertsuccess: { block: 'div', classes: 'alert-success', wrapper: true }
    }
};