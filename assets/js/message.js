function message(message, type = "info", header = "", hide = 2500) {
    var color;
    var icon;

    switch (type) {
        case 'success':
            color = '#ff6849';
            icon = 'success';
            break;

        case 'warning':
            color = '#ff6849';
            icon = 'warning';
            break;

        case 'danger':
            color = '#ff6849';
            icon = 'error';
            break;

        case 'info':
        default:
            color = '#ff6849';
            icon = 'info';
            break;
    }
    
    $.toast({
        heading: header,
        text: message,
        position: 'top-right',
        loaderBg: color,
        icon: icon,
        hideAfter: hide,
        stack: 6
    });
}