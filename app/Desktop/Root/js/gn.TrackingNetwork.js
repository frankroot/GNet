// Init Ladda Plugin on buttons
// Ladda.bind('.ladda-button', {
//     timeout: 3000
// });

// Bind progress buttons and simulate loading progress. Still requires ".ladda-button" class.
Ladda.bind('.progress-button', {
    callback: function(instance) {
        var progress = 0;
        var interval = setInterval(function() {
            progress = Math.min(progress + Math.random() * 0.1, 1);
            instance.setProgress(progress);

            if (progress === 1) {
                instance.stop();
                clearInterval(interval);
            }
        }, 200);
    }
});
    
$('.creating-admin-panels').adminpanel({
    grid: '.admin-grid',
    draggable: false,
    preserveGrid: true,
    mobile: true,
    // On AdminPanel Init complete we fade in the content. Optional
    onFinish: function() {
        $('.creating-admin-panels').addClass('animated fadeIn').removeClass('fade-onload');
    },
    // We trigger a window resize after a panel has been modified. This helps catch
    // any plugins which may need to update after the panel was changed. Optional
    onSave: function() {
        $(window).trigger('resize');
    }
});