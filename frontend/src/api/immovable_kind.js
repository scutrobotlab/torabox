import { fetchApi } from "./internal";

export async function getImmovableKinds() {
  const resp = await fetchApi("/api/immovable_kinds");
  return resp.immovable_kinds;
}

export async function getImmovableKindIndex(id) {
  const resp = await fetchApi("/api/immovable_kinds/" + id);
  return resp.immovable_kind;
}

export async function getImmovableKindIndexEdit(id) {
  const resp = await fetchApi("/api/immovable_kinds/" + id + "/edit");
  return resp.access;
}

export async function getImmovableKindIndexImmovables(id) {
  const resp = await fetchApi("/api/immovable_kinds/" + id + "/immovables");
  return resp.immovables;
}

export async function deleteImmovableKind(id) {
  return await fetchApi("/api/immovable_kinds/" + id, "DELETE");
}

export async function postImmovableKind(immovable_kind) {
  const resp = await fetchApi("/api/immovable_kinds", "POST", {
    name: immovable_kind.name,
    group_id: immovable_kind.group_id,
    description: immovable_kind.description,
  });
  return resp.immovable;
}
