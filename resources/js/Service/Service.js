import axios from "axios";


export async function getResources() {
    const response = await axios.get(("/admin/dashboard/resource"));
    return response.data["resource"];
}

export async function getInterfaces() {
    const response = await axios.get(("/admin/dashboard/interface"));
    return response.data["interface"];
}

