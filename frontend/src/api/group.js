import { fetchApi } from "./internal";

export async function getGroups() {
  const resp = await fetchApi("/api/groups");
  return resp.groups;
}

export async function getGroupIndex(id) {
  const resp = await fetchApi("/api/groups/" + id);
  return resp.groups;
}

export async function getGroupIndexUsers(id) {
  const resp = await fetchApi("/api/groups/" + id + "/users");
  return resp.users;
}

export async function getGroupIndexMembers(id) {
  const resp = await fetchApi("/api/groups/" + id + "/members");
  return resp.users;
}

export async function getGroupIndexLeaders(id) {
  const resp = await fetchApi("/api/groups/" + id + "/leaders");
  return resp.users;
}
