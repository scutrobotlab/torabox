import { fetchApi } from "./internal";

export async function getImmovableApplications() {
  const resp = await fetchApi("/api/immovable_applications");
  return resp.immovable_applications;
}

export async function postImmovableApplication(immovable_application) {
  const resp = await fetchApi("/api/immovable_applications", "POST", {
    immovable_id: immovable_application.immovable_id,
    approver_id: immovable_application.approver_id,
    action: immovable_application.action,
    description: immovable_application.description,
  });
  return resp.immovable_application;
}

export async function getImmovableApplicationIndex(id) {
  const resp = await fetchApi("/api/immovable_applications/" + id);
  return resp.immovable_application;
}

export async function getImmovableApplicationIndexEdit(id) {
  const resp = await fetchApi("/api/immovable_applications/" + id + "/edit");
  return resp.access;
}

export async function putImmovableApplication(id, immovable_application) {
  const resp = await fetchApi("/api/immovable_applications/" + id, "PUT", {
    status: immovable_application.status,
    description: immovable_application.description,
  });
  return resp.immovable_application;
}

export async function deleteImmovableApplication(id) {
  return await fetchApi("/api/immovable_applications/" + id, "DELETE");
}
