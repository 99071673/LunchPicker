@props(['deadline'])

<p id="{{ $attributes->get('id', 'countdown') }}" class="text-7xl font-bold flex justify-center">00:00:00</p>

<script>
    (function () {
        const deadline = new Date("{{ $deadline }}").getTime();
        const el = document.getElementById("{{ $attributes->get('id', 'countdown') }}");

        function pad(n) {
            return n.toString().padStart(2, '0');
        }

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = deadline - now;

            if (distance <= 0) {
                el.textContent = "00:00:00";
                clearInterval(timerInterval);
                return;
            }

            const totalSeconds = Math.floor(distance / 1000);
            const hours = Math.floor(totalSeconds / 3600);
            const minutes = Math.floor((totalSeconds % 3600) / 60);
            const seconds = totalSeconds % 60;

            el.textContent = `${pad(hours)}:${pad(minutes)}:${pad(seconds)}`;
        }

        updateCountdown();
        const timerInterval = setInterval(updateCountdown, 1000);
    })();
</script>
