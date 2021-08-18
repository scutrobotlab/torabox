import { fetchApi } from "./internal";

export async function getConfig() {
  return await fetchApi("/api/configs");
}
