import { fetchApi } from "./internal";

export function createUserOAuthURL(config, state = "") {
  const url = new URL(config["oauth_url"] + "/oauth/authorize");
  url.searchParams.set("client_id", config["oauth_client_id"]);
  url.searchParams.set("redirect_uri", window.location.origin + "/user/callback");
  url.searchParams.set("state", state);
  return url.href;
}

export async function getUserSelfSession() {
  const resp = await fetchApi("/api/users/self/session");
  return resp.success;
}

export async function postUserSelfSession(code) {
  const resp = await fetchApi("/api/users/self/session", "POST", { code });
  return resp.user;
}

export async function deleteUserSelfSession() {
  return await fetchApi("/api/users/self/session", "DELETE");
}

export async function getUserSelf() {
  const resp = await fetchApi("/api/users/self");
  return resp.user;
}

export async function getUserSelfNotificationCount() {
  const resp = await fetchApi("/api/users/self/notification_count");
  return resp.notification_count;
}

export async function getUserSelfImmovablesOwned() {
  const resp = await fetchApi("/api/users/self/immovables_owned");
  return resp.immovables;
}

export async function getUserSelfImmovableApplicationsApplied(pending = "") {
  const resp = await fetchApi("/api/users/self/immovable_applications_applied?pending=" + pending);
  return resp.immovable_applications;
}

export async function getUserSelfImmovableApplicationsApproved(pending = "") {
  const resp = await fetchApi("/api/users/self/immovable_applications_approved?pending=" + pending);
  return resp.immovable_applications;
}

export async function getUserSelfConsumableApplicationsApplied(pending = "") {
  const resp = await fetchApi("/api/users/self/consumable_applications_applied?pending=" + pending);
  return resp.consumable_applications;
}

export async function getUserSelfConsumableApplicationsApproved(pending = "") {
  const resp = await fetchApi(
    "/api/users/self/consumable_applications_approved?pending=" + pending
  );
  return resp.consumable_applications;
}

export async function putUserSelf() {
  const resp = await fetchApi("/api/users/self", "PUT");
  return resp.user;
}

export async function getUserIndex(id) {
  const resp = await fetchApi("/api/users/" + id);
  return resp.user;
}

export async function getFakeUsers() {
  const resp = await fetchApi("/api/users_fake");
  return resp.users;
}

export async function getFakeUserIndex(id) {
  const resp = await fetchApi("/api/users_fake/" + id);
  return resp.user;
}

export async function postFakeUserSelfSession(id) {
  const resp = await fetchApi("/api/users_fake/self/session", "POST", { id });
  return resp.user;
}
