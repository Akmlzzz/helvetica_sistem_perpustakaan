import QRCode from 'qrcode';

// Generate QR Code for member ID
export async function generateMemberQR(memberId) {
    try {
        const qrDataUrl = await QRCode.toDataURL(memberId, {
            width: 80,
            margin: 1,
            color: {
                dark: '#000000',
                light: '#FFFFFF'
            }
        });
        return qrDataUrl;
    } catch (error) {
        console.error('Error generating QR code:', error);
        return null;
    }
}

// Initialize QR codes when page loads
document.addEventListener('DOMContentLoaded', async function() {
    const qrElements = document.querySelectorAll('[data-qr-member-id]');
    
    for (const element of qrElements) {
        const memberId = element.dataset.qrMemberId;
        if (memberId) {
            const qrDataUrl = await generateMemberQR(memberId);
            if (qrDataUrl) {
                element.innerHTML = `<img src="${qrDataUrl}" alt="QR Code" class="w-full h-full rounded">`;
            }
        }
    }
});
