import { alertStore } from "@/store/alertStore";

class FileValidator {
    validExtensions = ['image/jpeg', 'image/jpg', 'image/png'];
    fileSize = 5 * 1024 * 1024; // 5MB

    validIconExtensions = ['image/vnd.microsoft.icon', 'image/x-icon', 'image/jpeg', 'image/jpg', 'image/png'];
    iconFileSize = 5 * 1024 * 1024; // 5MB

    validImage(image) {
        if (image.size > this.fileSize) {
            alertStore.addAlert('info', 'A imagem deve ter no máximo 5MB.');
            return false;
        }

        if (!this.validExtensions.includes(image.type)) {
            alertStore.addAlert('info', 'O formato da imagem deve ser (png, jpg ou jpeg)');
            return false;
        }

        return true;
    }

    validIcon(icon) {
        if (icon.size > this.iconFileSize) {
            alertStore.addAlert('info', 'O ícone deve ter no máximo 5MB.');
            return false;
        }
    
        if (!this.validIconExtensions.includes(icon.type)) {
            alertStore.addAlert('info', 'O formato do ico deve ser um ícone ICO ou JPG, JPEG ou PNG.');
            return false;
        }
    
        return true;
    }
}

export default new FileValidator();