<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {
        window.Echo.channel('new-message-channel')
            .listen('NewMessageNotification2', (notification) => {
                // Puedes personalizar cómo se muestra la notificación en tu aplicación Blade
                // Aquí podrías llamar a alguna función de Blade para mostrar la notificación
                // o simplemente actualizar el DOM según tus necesidades.
                alert('Tienes un nuevo mensaje: ' + notification.message.message);
            });
    },
};
</script>
