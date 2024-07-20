import { ElNotification } from 'element-plus'

export function showAlert (type, title, message) {
    ElNotification({
        title: title,
        message: message,
        type: type,
    });
}