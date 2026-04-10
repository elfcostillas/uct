import { useConfirm } from "primevue";
import { useToast } from "primevue";
import { postFN } from '@/api/transmit.js';

export default function useConfirmSave() {
    const confirm = useConfirm();
    const toast = useToast();

    const confirmAndSave = async ({
        data,
        url,
        onSuccess = () => {},
        onError = () => {},
        successMessage = 'Saved successfully'
    }) => {

        confirm.require({
            message: 'Are you sure you want to proceed?',
            header: 'Confirmation',
            icon: 'pi pi-exclamation-triangle',
            acceptProps: {
                label: 'Save',
                icon: 'pi pi-save',
            },
            rejectProps: {
                label: 'Cancel',
                severity: 'secondary',
                outlined: true
            },

            accept: async () => {
                console.log(data);
                try {
                    const response = await postFN(url, data);

                    toast.add({
                        severity: 'success',
                        summary: 'Success',
                        detail: response.data.message || successMessage,
                        life: 3000
                    });

                    onSuccess();

                } catch (error) {

                    let message = '';

                    if (error.response) {

                        if (error.response.status === 401) {
                            toast.add({
                                severity: 'warn',
                                summary: 'Unauthorized',
                                detail: 'Session expired. Please login again.',
                                life: 4000
                            });
                            return;
                        }

                        if (error.response.status === 422) {
                            Object.values(error.response.data.errors).forEach(arr => {
                                arr.forEach(msg => message += msg + '\n');
                            });
                        } else {
                            message = error.response.data.message || 'Error occurred';
                        }

                    } else {
                        message = 'Network error';
                    }

                    toast.add({
                        severity: 'error',
                        summary: 'Error',
                        detail: message,
                        life: 3000
                    });

                    // onError(error);
                }
            }
        });
    };

    return { confirmAndSave };
}