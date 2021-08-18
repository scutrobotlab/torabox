export async function fetchApi(url, method = "GET", body = null) {
  let init = {
    method,
    headers: new Headers({
      "Content-Type": "application/json",
    }),
  };

  if (body != null && (method == "POST" || method == "PUT" || method == "DELETE")) {
    init.body = JSON.stringify(body);
  }

  const response = await fetch(url, init);

  if (response.status == 204) {
    return;
  }

  if (response.status == 401) {
    localStorage.removeItem("login");
    location.reload();
  }

  const text = await response.text();
  let json = null;
  try {
    json = JSON.parse(text);
  } catch (e) {
    throw { status: response.status, data: text };
  }

  if (response.ok) {
    return json;
  }
  throw { status: response.status, data: json.message };
}
