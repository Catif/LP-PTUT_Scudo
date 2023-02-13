import { defineStore } from "pinia";

export const useUtils = defineStore(
  "utils",
  () => {
    function formatNumber(number, digits) {
      const lookup = [
        { value: 1, symbol: "" },
        { value: 1e3, symbol: "k" },
        { value: 1e6, symbol: "M" },
        { value: 1e9, symbol: "G" },
        { value: 1e12, symbol: "T" },
        { value: 1e15, symbol: "P" },
        { value: 1e18, symbol: "E" },
      ];
      const rx = /\.0+$|(\.[0-9]*[1-9])0+$/;
      var item = lookup
        .slice()
        .reverse()
        .find(function (item) {
          return number >= item.value;
        });
      return item ? (number / item.value).toFixed(digits).replace(rx, "$1") + item.symbol : "0";
    }

    return { formatNumber };
  },
  {
    persist: true,
  }
);
