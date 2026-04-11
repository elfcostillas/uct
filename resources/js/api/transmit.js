import api from "./api";
import { ref } from "vue";

export const postFN = async (url, data) => {
    try {
        const response = await api.post(url, data); 
        return response;
    } catch (error) {
        console.error('Error occurred while posting data:', error);
        throw error;
    }
};

export const getFN = async (url,params) => {
    try {
        const response = await api.get(url,{ params : params});           
        return response;
    } catch (error) {
        console.error('Error occurred while fetching data:', error);
        throw error;
    }
};