import { fetchApi } from "./internal";

export async function getConsumablePurchases() {
  const resp = await fetchApi("/api/consumable_purchases");
  return resp.consumable_purchases;
}

export async function postConsumablePurchase(consumable_purchase) {
  const resp = await fetchApi("/api/consumable_purchases", "POST", {
    consumable_id: consumable_purchase.consumable_id,
    number: consumable_purchase.number,
    description: consumable_purchase.description,
  });
  return resp.consumable_purchase;
}

export async function getConsumablePurchaseIndex(id) {
  const resp = await fetchApi("/api/consumable_purchases/" + id);
  return resp.consumable_purchase;
}

export async function deleteConsumablePurchase(id) {
  return await fetchApi("/api/consumable_purchases/" + id, "DELETE");
}
