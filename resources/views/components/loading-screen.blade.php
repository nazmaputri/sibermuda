<style>
    /* Fallback style agar animasi muncul langsung saat HTML dibaca */
    #loading-screen {
        position: fixed;
        inset: 0;
        background-color: white;
        z-index: 9999;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    #loading-screen .dot {
        width: 16px;
        height: 16px;
        background-color: #3b82f6; /* Tailwind blue-500 */
        border-radius: 9999px;
        animation: bounce 1s infinite;
        margin: 0 4px;
    }

    #loading-screen .dot:nth-child(2) {
        animation-delay: 0.15s;
    }

    #loading-screen .dot:nth-child(3) {
        animation-delay: 0.3s;
    }

    @keyframes bounce {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-12px);
        }
    }
</style>

<div id="loading-screen">
    <div class="dots flex space-x-2">
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
    </div>
</div>
