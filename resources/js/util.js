export const OK = 200;
export const CREATED = 201;
export const UNAUTHORIZED = 419;
export const UNPROCESSABLE_ENTITY = 422;
export const INTERNAL_SERVER_ERROR = 500;

export function getCookie(searchKey) {
  if (typeof searchKey === 'undefined') {
    return '';
  }

  document.cookie.split(';').forEach(cookie => {
    const [key, value] = cookie.split('=');
    if (key === searchKey) {
      return value;
    }
  });

  // not found
  return '';
}
