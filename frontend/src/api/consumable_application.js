import { fetchApi } from "./internal";

export async function getConsumableApplications(page) {
  const resp = await fetchApi("/api/consumable_applications?page=" + page);
  return resp.consumable_applications;
}

export async function getConsumableApplicationPaginationLength() {
  const resp = await fetchApi("/api/consumable_applications/pagination_length");
  return resp.pagination_length;
}

export async function postConsumableApplication(consumable_application) {
  const resp = await fetchApi("/api/consumable_applications", "POST", {
    consumable_id: consumable_application.consumable_id,
    approver_id: consumable_application.approver_id,
    number: consumable_application.number,
    description: consumable_application.description,
  });
  return resp.consumable_application;
}

export async function getConsumableApplicationIndex(id) {
  const resp = await fetchApi("/api/consumable_applications/" + id);
  return resp.consumable_application;
}

export async function getConsumableApplicationIndexEdit(id) {
  const resp = await fetchApi("/api/consumable_applications/" + id + "/edit");
  return resp.access;
}

export async function putConsumableApplication(id, consumable_application) {
  const resp = await fetchApi("/api/consumable_applications/" + id, "PUT", {
    status: consumable_application.status,
    description: consumable_application.description,
  });
  return resp.consumable_application;
}

export async function deleteConsumableApplication(id) {
  return await fetchApi("/api/consumable_applications/" + id, "DELETE");
}
