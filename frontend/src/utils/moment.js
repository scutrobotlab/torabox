import moment from "moment";

moment.locale("zh-cn");

export function fromNow(dateTime) {
  return moment(dateTime).fromNow();
}

export function format(dateTime) {
  return moment(dateTime).format("lll");
}
