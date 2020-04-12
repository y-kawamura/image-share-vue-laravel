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
