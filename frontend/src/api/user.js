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
