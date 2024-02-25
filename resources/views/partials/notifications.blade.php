<div id="notifications-container">
    @foreach ($notifications as $notification)
        <div class="notification">
            {{ $notification->message }}
            <!-- Puedes agregar más detalles o enlaces aquí -->
        </div>
    @endforeach
</div>