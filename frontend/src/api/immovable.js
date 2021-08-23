import { fetchApi } from "./internal";

export async function getImmovables() {
  const resp = await fetchApi("/api/immovables");
  return resp.immovables;
}

export async function getImmovableIndex(id) {
  const resp = await fetchApi("/api/immovables/" + id);
  return resp.immovable;
}

export async function getImmovableIndexEdit(id) {
  const resp = await fetchApi("/api/immovables/" + id + "/edit");
  return resp.access;
}

export async function deleteImmovable(id) {
  return await fetchApi("/api/immovables/" + id, "DELETE");
}

export async function getImmovableIndexApplications(id) {
  const resp = await fetchApi("/api/immovables/" + id + "/applications");
  return resp.immovable;
}

export async function getImmovableIndexApprovers(id) {
  const resp = await fetchApi("/api/immovables/" + id + "/approvers");
  return resp.immovable;
}

export async function postImmovable(immovable) {
  const resp = await fetchApi("/api/immovables", "POST", {
    name: immovable.name,
    immovable_kind_id: immovable.immovable_kind_id,
    need_approval: immovable.need_approval,
    description: immovable.description,
  });
  return resp.immovable;
}
