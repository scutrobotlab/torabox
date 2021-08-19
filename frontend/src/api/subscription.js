import { fetchApi } from "./internal";

export async function getSubscriptions() {
  const resp = await fetchApi("/api/subscriptions");
  return resp.subscriptions;
}

export async function getSubscriptionIndex(id) {
  const resp = await fetchApi("/api/subscriptions/" + id);
  return resp.subscription;
}

export async function getSubscriptionIndexEdit(id) {
  const resp = await fetchApi("/api/subscriptions/" + id + "/edit");
  return resp.access;
}

export async function deleteSubscription(id) {
  return await fetchApi("/api/subscriptions/" + id, "DELETE");
}

export async function postSubscription(subscription) {
  const resp = await fetchApi("/api/subscriptions", "POST", {
    group_id: subscription.group_id,
    name: subscription.name,
    end_time: subscription.end_time,
    description: subscription.description,
  });
  return resp.subscription;
}

export async function putSubscription(id, subscription) {
  const resp = await fetchApi("/api/subscriptions/" + id, "PUT", {
    group_id: subscription.group_id,
    user_id: subscription.user_id,
    name: subscription.name,
    end_time: subscription.end_time,
    description: subscription.description,
  });
  return resp.subscription;
}
