import { fetchApi } from "./internal";

export async function getConsumables() {
  const resp = await fetchApi("/api/consumables");
  return resp.consumables;
}

export async function getConsumableIndex(id) {
  const resp = await fetchApi("/api/consumables/" + id);
  return resp.consumable;
}

export async function getConsumableIndexEdit(id) {
  const resp = await fetchApi("/api/consumables/" + id + "/edit");
  return resp.access;
}

export async function deleteConsumable(id) {
  return await fetchApi("/api/consumables/" + id, "DELETE");
}

export async function getConsumableIndexApplications(id) {
  const resp = await fetchApi("/api/consumables/" + id + "/applications");
  return resp.consumable;
}

export async function getConsumableIndexPurchases(id) {
  const resp = await fetchApi("/api/consumables/" + id + "/purchases");
  return resp.consumable;
}

export async function getConsumableIndexApprovers(id) {
  const resp = await fetchApi("/api/consumables/" + id + "/approvers");
  return resp.consumable;
}

export async function postConsumable(consumable) {
  const resp = await fetchApi("/api/consumables", "POST", {
    group_id: consumable.group_id,
    name: consumable.name,
    need_approval: consumable.need_approval,
    description: consumable.description,
  });
  return resp.consumable;
}

export async function putConsumable(id, consumable) {
  const resp = await fetchApi("/api/consumables/" + id, "PUT", {
    name: consumable.name,
    description: consumable.description,
  });
  return resp.consumable;
}
